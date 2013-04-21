<?php
    /**
    *
    * Caching Class
    * From: http://www.webgeekly.com/
    *
    **/

    class Caching
    {

        protected static $sCacheDir = './';
        protected static $sCacheExt = '.cachefile';
        protected static $sPrefix = '';

        private $sCacheName = '';
        private $iCacheTime;

        public function __construct() {
            global $_SERVER;
            $this->sPrefix = md5($_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].$_SERVER["QUERY_STRING"]);
        }

        protected function write($iCacheTime, $sData)
        {
            $sFilename = $this->getFilename();

            if ($fp = fopen($sFilename, 'xb')) {

                if (flock($fp, LOCK_EX)) {
                    fwrite($fp, $sData);
                }
                fclose($fp);

                touch($sFilename, time() + $iCacheTime);
            }
        }

        protected function read()
        {
            $sPage = $this->sCacheName;
            $sFilename = self::$sCacheDir . self::$sPrefix
                         . $sPage . self::$sCacheExt;
            return readfile($sFilename);
        }

        protected function isCached()
        {
            $sFilename = $this->getFilename();

            if (file_exists($sFilename)
                && filemtime($sFilename) > time()) {
                return true;
            }

            @unlink($sFilename);

            return false;
        }

        protected function getFilename()
        {
            $sPage = $this->sCacheName;
            return self::$sCacheDir . self::$sPrefix
                   . $sPage . self::$sCacheExt;
        }

        public function getCache($sCacheName, $iCacheTime = 64800) {

            $this->sCacheName = $this->sPrefix . $sCacheName;

            if ($iCacheTime == 0) return false;

            if ($this->isCached()) {
                $this->read();
                return true;
            } else {
                ob_start();
                $this->iCacheTime = $iCacheTime;
                return false;
            }

        }

        public function saveCache() {

            $sData = ob_get_contents();
            ob_end_flush();
            $this->write($this->iCacheTime, $sData);

        }

    }
?>