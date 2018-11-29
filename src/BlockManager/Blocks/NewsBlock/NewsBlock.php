<?php

namespace App\BlockManager\Blocks\NewsBlock;

use App\BlockManager\Base\BlockModelInterface;

class NewsBlock implements BlockModelInterface {
    const LAYOUT_FIRST_BIG = 0;
    const LAYOUT_TWO_COLUMNS = 1;
    const LAYOUT_ALL_BIG = 2;

    /**
     * Layout
     *
     * @var integer
     */
    private $layout;

    /**
     * Max num of news
     *
     * @var integer
     */
    private $limit = 5;

    /**
     * Show "more news" text
     *
     * @var bool
     */
    private $show_more_news;

    /**
     * Read more text
     *
     * @var string
     */
    private $text_read_more = "Read more";


    /**
     * More news text
     *
     * @var string
     */
    private $text_more_news = "More news";

    /**
     * Read more text
     *
     * @var string
     */
    private $text_no_news = "No news to show";

    /**
     * Show date
     *
     * @var bool
     */
    private $show_date;

    /**
     * Show author
     *
     * @var bool
     */
    private $show_author;


    /**
     * Get layout
     *
     * @return  integer
     */ 
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Set layout
     *
     * @param  integer  $layout  Layout
     *
     * @return  self
     */ 
    public function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Get max num of news
     *
     * @return  integer
     */ 
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set max num of news
     *
     * @param  integer  $limit  Max num of news
     *
     * @return  self
     */ 
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * Get show "more news" text
     *
     * @return  bool
     */ 
    public function getShowMoreNews()
    {
        return $this->show_more_news;
    }

    /**
     * Set show "more news" text
     *
     * @param  bool  $show_more_news  Show "more news" text
     *
     * @return  self
     */ 
    public function setShowMoreNews(bool $show_more_news)
    {
        $this->show_more_news = $show_more_news;

        return $this;
    }

    /**
     * Get read more text
     *
     * @return  string
     */ 
    public function getTextReadMore()
    {
        return $this->text_read_more;
    }

    /**
     * Set read more text
     *
     * @param  string  $text_read_more  Read more text
     *
     * @return  self
     */ 
    public function setTextReadMore(string $text_read_more)
    {
        $this->text_read_more = $text_read_more;

        return $this;
    }

    /**
     * Get more news text
     *
     * @return  string
     */ 
    public function getTextMoreNews()
    {
        return $this->text_more_news;
    }

    /**
     * Set more news text
     *
     * @param  string  $text_more_news  More news text
     *
     * @return  self
     */ 
    public function setTextMoreNews(string $text_more_news)
    {
        $this->text_more_news = $text_more_news;

        return $this;
    }

    /**
     * Get show date
     *
     * @return  bool
     */ 
    public function getShowDate()
    {
        return $this->show_date;
    }

    /**
     * Set show date
     *
     * @param  bool  $show_date  Show date
     *
     * @return  self
     */ 
    public function setShowDate(bool $show_date)
    {
        $this->show_date = $show_date;

        return $this;
    }

    /**
     * Get show author
     *
     * @return  bool
     */ 
    public function getShowAuthor()
    {
        return $this->show_author;
    }

    /**
     * Set show author
     *
     * @param  bool  $show_author  Show author
     *
     * @return  self
     */ 
    public function setShowAuthor(bool $show_author)
    {
        $this->show_author = $show_author;

        return $this;
    }

    /**
     * Get read more text
     *
     * @return  string
     */ 
    public function getTextNoNews()
    {
        return $this->text_no_news;
    }

    /**
     * Set read more text
     *
     * @param  string  $text_no_news  Read more text
     *
     * @return  self
     */ 
    public function setTextNoNews(string $text_no_news)
    {
        $this->text_no_news = $text_no_news;

        return $this;
    }
}
