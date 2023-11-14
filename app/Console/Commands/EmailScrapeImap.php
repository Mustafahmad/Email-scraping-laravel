<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class EmailScrapeImap extends Command
{
    protected $signature = 'email:scrape-imap';
    protected $description = 'Scrape emails from a mailbox using IMAP';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $mailbox = '{imap.gmail.com:993/imap/ssl}INBOX';
        // $mailbox = '{outlook.office365.com:993/imap/ssl}INBOX'; 
        $scrapedData = []; 
        $emailCount = 0; 
        $datePattern = '/\b(?:Sunday|Monday|Tuesday|Wednesday|Thursday|Friday|Saturday),?\s+\d{1,2}\s+(?:January|February|March|April|May|June|July|August|September|October|November|December|Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s+\d{4}\b/';
        $Imagepattern = '/\[image:\s(.*?)\]/';


        // Connect to the mailbox
        $imapStream = imap_open($mailbox, 'email', 'password');

        if (!$imapStream) {
            $this->error('Unable to connect to the mailbox.');
            return;
        }

    
        $emails = imap_search($imapStream, 'ALL');

        if ($emails) {
            foreach ($emails as $emailNumber) {
              
                $emailData = imap_fetchbody($imapStream, $emailNumber, 1);
                $headers = imap_headerinfo($imapStream, $emailNumber);
         
                // Extract sender and receiver addresses
                $senderAddress = $headers->from[0]->mailbox . '@' . $headers->from[0]->host;
                $receiverAddress = $headers->to[0]->mailbox . '@' . $headers->to[0]->host;

                // Extract names from email body using regular expressions
                $name = null;
                if (preg_match('/New booking confirmed!\s*(\S+)/', $emailData, $matches)) {
                    $name = $matches[1];
                }
                // // $emailText = imap_body($imapStream, $emailNumber);
                // // $names = [];
                // // if (preg_match_all('/\b[A-Z][a-z]+(?: [A-Z][a-z]+)?\b/', $emailData, $matches)) {
                // //     $names = $matches[0];
                // }
                $datesWithMonthNames = [];
                if (preg_match_all($datePattern, $emailData, $dateMatches)) {
                    $datesWithMonthNames = $dateMatches[0];
                }
                $property_name = [];
                $count = 0; 
                if (preg_match_all($Imagepattern, $emailData, $propertyMatches)) {
                    foreach ($propertyMatches[0] as $value) { 
                        $count++;
                        if ($count === 3) {
                            $property_name [] = $value; 
                        }
                    }
                }
      
                $date = $headers->date;

                $scrapedData[] = [
                    'sender' => $senderAddress,
                    'receiver' => $receiverAddress,
                    'name' => $name,
                    'dates_with_month_names' => $datesWithMonthNames,
                    'date' => $date,
                    'property' => $property_name ,
                ];

                // Increment the email counter
                $emailCount++;

                $this->info("Email # $emailNumber scraped.");
            }
        } else {
            $this->info('No emails found in the mailbox.');
        }

            imap_close($imapStream);

        $this->info("Total emails processed: $emailCount");

        Storage::put('scraped_data.json', json_encode($scrapedData));
        
    }
}
