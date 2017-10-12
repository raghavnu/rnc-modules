<?php
namespace Acme\Library {

    use Exception;

    class Pagination
    {

        public static $total;
        public static $page;
        public static $per_page;
        public static $url;
        public static $params = '';

        public  function __construct($page = 1, $per_page = 12, $total, $url = '')
        {

            self::$total    = $total;
            self::$page     = $page;
            self::$per_page = $per_page;
            self::$url      = $url;

        }

        public static function params($parameters)
        {
            $query = '';

            if (is_array($parameters) && $parameters != null) {

                $query = '?';

                foreach ($parameters as $key => $val) {
                    if ($val != '') {
                        $query .= $key . '=' . $val . '&';
                    }

                }

                $query .= 'page=';

            }

            return self::$params = $query;
        }

        public static function parse()
        {
            self::_check();

            $total = self::$total;
            $page = self::$page;
            $per_page = self::$per_page;

            if (self::$params != '') {
                $url = self::$url . self::$params;
            } else {
                $url = self::$url . '?page=';
            }


            $adjacents = "2";

            $page = ($page == 0 ? 1 : $page);
            $start = ($page - 1) * $per_page;

            $prev = $page - 1;
            $next = $page + 1;
            $lastpage = ceil($total / $per_page);
            $lpm1 = $lastpage - 1;

            $pagination = "";
            if ($lastpage > 1) {
                $pagination .= "<ul class='pagination'>";
                $pagination .= "<li class='details'>Page $page of $lastpage</li>";
                if ($lastpage < 7 + ($adjacents * 2)) {
                    for ($counter = 1; $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li><a class='current'>$counter</a></li>";
                        else
                            $pagination .= "<li><a   href='{$url}$counter'>$counter</a></li>";
                    }
                } elseif ($lastpage > 5 + ($adjacents * 2)) {
                    if ($page < 1 + ($adjacents * 2)) {
                        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                            if ($counter == $page)
                                $pagination .= "<li><a class='current'>$counter</a></li>";
                            else
                                $pagination .= "<li><a    href='{$url}$counter'>$counter</a></li>";
                        }
                        $pagination .= "<li class='dot'>...</li>";
                        $pagination .= "<li><a   href='{$url}$lpm1'>$lpm1</a></li>";
                        $pagination .= "<li><a   href='{$url}$lastpage'>$lastpage</a></li>";
                    } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                        $pagination .= "<li><a   href='{$url}1'>1</a></li>";
                        $pagination .= "<li><a    href='{$url}2'>2</a></li>";
                        $pagination .= "<li class='dot'>...</li>";
                        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                            if ($counter == $page)
                                $pagination .= "<li><a class='current'>$counter</a></li>";
                            else
                                $pagination .= "<li><a  href='{$url}$counter'>$counter</a></li>";
                        }
                        $pagination .= "<li class='dot'>..</li>";
                        $pagination .= "<li><a    href='{$url}$lpm1'>$lpm1</a></li>";
                        $pagination .= "<li><a    href='{$url}$lastpage'>$lastpage</a></li>";
                    } else {
                        $pagination .= "<li><a   href='{$url}1'>1</a></li>";
                        $pagination .= "<li><a    href='{$url}2'>2</a></li>";
                        $pagination .= "<li class='dot'>..</li>";
                        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                            if ($counter == $page)
                                $pagination .= "<li><a class='current'>$counter</a></li>";
                            else
                                $pagination .= "<li><a    href='{$url}$counter'>$counter</a></li>";
                        }
                    }
                }

                if ($page < $counter - 1) {
                    $pagination .= "<li><a  href='{$url}$next'>Next</a></li>";
                    $pagination .= "<li><a  href='{$url}$lastpage'>Last</a></li>";
                } else {
                    $pagination .= "<li><a class='current'>Next</a></li>";
                    $pagination .= "<li><a class='current'>Last</a></li>";
                }
                $pagination .= "</ul>\n";
            }
            return $pagination;
        }

        protected static function _check()
        {
            if (!isset(self::$page)) {
                throw new Exception('Pagination::initial page must be set.');
            } elseif (!isset(self::$total)) {
                throw new Exception('Pagination::total must be set.');
            } elseif (!isset(self::$per_page)) {
                throw new Exception('Pagination::limit must be set.');
            }
        }

        public static function getOffset($page, $limit)
        {

            $offset = ($page - 1) * $limit;
            return $offset;

        }

    }// Class

}// Namespace
