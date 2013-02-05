<?php
define('SCSS_PRODUCTION_MODE',false);
define('SCSS_URL','scss/compiled');

define('SCSS_DEBUG', !SCSS_PRODUCTION_MODE);
define('SCSS_DIR',dirname(__FILE__));
define('SCSS_COMPILED',SCSS_DIR.DIRECTORY_SEPARATOR.'compiled');



function letScssBoom($srcFile){
    $dest=  dirname($srcFile).'/'.pathinfo($srcFile,PATHINFO_FILENAME).'.css';
    $destUrl=SCSS_URL.'/'.$dest;

    if(SCSS_PRODUCTION_MODE || (file_exists(SCSS_COMPILED.DIRECTORY_SEPARATOR.$dest) && filemtime(SCSS_COMPILED.DIRECTORY_SEPARATOR.$dest)>  filemtime(SCSS_DIR.DIRECTORY_SEPARATOR.$srcFile))){
        echo $destUrl.'?'.filemtime(SCSS_COMPILED.DIRECTORY_SEPARATOR.$dest);
        return;
    }
    @mkdir(dirname(SCSS_COMPILED.DIRECTORY_SEPARATOR.$dest),true);
    $sc=new scssCompiler();
    $sc->destFile=SCSS_COMPILED.DIRECTORY_SEPARATOR.$dest;
    $sc->srcFile=SCSS_DIR.DIRECTORY_SEPARATOR.$srcFile;
    $sc->includePath=SCSS_DIR;
    $sc->debug=SCSS_DEBUG;
    $sc->backTrace=SCSS_DEBUG;
    try{
        $sc->proccessFile();
        echo $destUrl.'?'.filemtime(SCSS_COMPILED.DIRECTORY_SEPARATOR.$dest);
    } catch (Exception $e){
        while(ob_get_level()!==0){
            ob_get_clean();
        }
        echo '<div class="error">';
        echo nl2br($e->getMessage());
        echo '</div>';
        die;
    }
}


class scssCompiler
{

    public $debug = true;
    public $backTrace = false;
    public $style = 'nested';
    public $encoding = 'UTF-8';
    public $preserveLineNumbers = false;

    public $destFile;
    public $srcFile;
    public $includePath;

    public function proccessFile ()
    {
        $options = array ();
        $options[] = '-C';  //No Cache
        $options[] = '-f';  //Force
        $options[] = '-I ' . escapeshellarg($this->includePath);   //Import Path
        $options[] = '-E ' . escapeshellarg($this->encoding);
        $options[] = '-t ' . escapeshellarg($this->style);
        if ($this->preserveLineNumbers) {
            $options[] = '-l';
        } 
        if ($this->debug) {
            $options[] = '-g';
        }
        if ($this->backTrace) {
            $options[] = '--trace';
        }
        $output = array ();
        $cmd='sass ' . implode(' ', $options) . ' ' . escapeshellarg(str_replace('/', DIRECTORY_SEPARATOR, $this->srcFile)) . ' ' . escapeshellarg(str_replace('/', DIRECTORY_SEPARATOR, $this->destFile)) . ' 2>&1';
        exec($cmd, $output, $return);

        if ($return>0 && $this->debug) {
            throw new Exception('Scss Proccessing Failed' . "\nFile:".$this->srcFile ."\n\n" . implode("\n", $output));
        } else if($return>0 && !$this->debug){
            return false;
        } else {
            return true;
        }
    }



}

?>