<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Book;
use App\Chapter;
use App\Verse;
use App\Volume;

class SyncDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync database with crawled text.';

    private $urls = array();
    private $qpOptions = array(
        'encoding' => 'utf-8',
        'ignore_parser_warnings' => true
    );

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Pull down base HTML file
        $this->recursiveLinks("https://www.lds.org/scriptures?lang=eng");
        //echo "\n"; var_dump($this->urls);

        //array_push($this->urls,"https://www.lds.org/scriptures/nt/acts/6?lang=eng");
        //array_push($this->urls,"https://www.lds.org/scriptures/nt/print/acts/6?lang=eng");

        $this->storeText();
        echo "Finished\n";
    }

    private function storeText()
    {
        // GO THROUGH EACH URL
        foreach ($this->urls as $url) {
            // HAS TO BE IN PRINT FORMAT
            if (preg_match("~/print/~i", $url)) {
                $matches = array();
                // GRAB NECESSARY INFO FROM URL
                preg_match("~scriptures/(.+?)/print/(.+?)/.*(\d+)~", $url, $matches);
                if (count($matches) === 4) {
                    //var_dump($matches);

                    // VOLUME UPDATED
                    $volume = Volume::where('shorthand', $matches[1])
                        ->first();

                    if (!$volume) {  // ADD FORCE UDPATE LATER?
                        $volume = new Volume();
                        $volume->shorthand = $matches[1];

                        switch ($matches[1]) {
                            case 'ot':
                                $volume->name = 'Old Testament';
                                break;
                            case 'nt':
                                $volume->name = 'New Testament';
                                break;
                            case 'bofm':
                                $volume->name = 'Book of Mormon';
                                break;
                            case 'pgp':
                                $volume->name = 'Pearl of Great Price';
                                break;
                            default:
                                $volume->name = "";
                        }

                        $volume->save();
                    }

                    // GET ACTUAL HTML
                    $html = file_get_contents($url);
                    $bookTitle = htmlqp($html, '#details h1', $this->qpOptions)->text();

                    // BOOK UPDATED
                    $book = Book::where('shorthand', $matches[2])
                        ->where('volume_id', $volume->id)
                        ->first();

                    if (!$book) {
                        $book = new Book();
                        $book->shorthand = $matches[2];
                        $book->name = $bookTitle;
                        $book->volume_id = $volume->id;
                        $book->save();
                    }

                    // CHAPTER UPDATED
                    $chapter = Chapter::where('number', $matches[3])
                        ->where('book_id', $book->id)
                        ->first();

                    $summary = htmlqp($html, 'div.summary', $this->qpOptions);

                    if (!$chapter) {
                        $chapter = new Chapter();
                        $chapter->number = $matches[3];
                        $chapter->book_id = $book->id;
                        $chapter->summary = $this->knownTextIssuesFilter($summary->text());
                        $chapter->save();
                    }

                    $verses = htmlqp($html, 'div.verses p', $this->qpOptions);

                    foreach ($verses as $verse) {
                        $number = htmlqp($verse, '.verse', $this->qpOptions)->text();
                        $scripture = $this->removeHtmlMarkup(rawurldecode($verse->innerHTML()));
                        //$scripture = rawurldecode($verse->innerHTML());

                        $_verse = Verse::where('chapter_id', $chapter->id)
                            ->where('number', $number)
                            ->first();

                        if (!$_verse) {
                            $_verse = new Verse();
                            $_verse->chapter_id = $chapter->id;
                            $_verse->number = $number;
                            $_verse->save();
                        }

                        $_verse->scripture = $scripture;
                        $_verse->save();
                    }
                }
            }
        }
    }

    private function removeHtmlMarkup($text)
    {
        return preg_replace([
            "~(<a.*?>)([\w\s]{3,})(</a>)~",
            "~<span.*verse.*?>.*?</span>~",
            "~(<span.*?>)(.*?)(</span>)~",
            "~<a.*?>.*?</a>~",
            "~<sup.*?>(.|\s)*?</sup>~"
        ], [
            "$2",
            "",
            "$2",
            "",
            ""
        ], $text);
    }

    private function knownTextIssuesFilter($text)
    {
        return preg_replace([
            "~(\w+)(\?)(\w+)~"
        ], [
            "$1-$3"
        ], $text);
    }

    /**
     * Recursively crawl lds.org for scriptures.  Cannot use ~/print/~ here
     * to gather print only urls because they're not visible until you reach the main page.
     *
     * @param $uri
     */
    private function recursiveLinks($uri)
    {
        if (preg_match("~http\w?://~", $uri)) {
            $links = htmlqp(file_get_contents($uri), 'a', $this->qpOptions);

            foreach ($links as $link) {
                if ((preg_match("~http\w?://www.lds.org/scriptures/(bible|ot|nt|bofm|dc-testament|pgp|study-helps)+\?~", $link->attr('href'))
                        || preg_match("~http\w?://www.lds.org/scriptures/(bible|ot|nt|bofm|dc-testament|pgp|study-helps)+/.+\d+~", $link->attr('href')))
                    && !in_array($link->attr('href'), $this->urls)
                ) {
                    echo(".");
                    array_push($this->urls, $link->attr('href'));
                    $this->recursiveLinks($link->attr('href'));
                }
            }
        }
    }
}
