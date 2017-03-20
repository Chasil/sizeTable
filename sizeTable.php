<?php
/*
Plugin Name: Size Table
Plugin URI:  http://wtyczka.pandzia.pl
Description: Show Size Table with imported data from XML
Version:     1.0
Author:      Mateusz Wojcik
Author URI:  http://portfolio.pandzia.pl
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
Domain Path: /languages
*/

/*
 * License
 */

/*
 * No uninstaller, no validation, low budget ;)
 */

class SizeTable {
    
    public function __construct() {
        $this->chasil_registerHooks();
    }
    
    /*
     * Registering hooks
     */
    public function chasil_registerHooks(){
        
        add_action('admin_menu', array($this, 'chasil_controlPanel'));
        add_shortcode('chasil_SizeTable', array($this, 'chasil_sizeTable'));
        add_action('wp_enqueue_scripts', array($this, 'chasil_loadStyle'));
        add_action('admin_enqueue_scripts', array($this, 'chasil_loadStyle'));
    }
    
    /*
     * Create panel in Admin Panel
     */
    public function chasil_controlPanel(){
        add_menu_page('Size Table', 'Size Table', 'manage_options', 'chasil_sizeTableMenu', array($this, 'chasil_panelView'));
    }
    
    /*
     * Load Admin Panel template
     */
    public function chasil_panelView(){
        $uploadInfo = $this->chasil_uploadFile();
        $deleteInfo = $this->chasil_deleteFile();
        $files = $this->chasil_scanDir();
        include(dirname(__FILE__) . '/views/panel.php');
    }
    
    /*
     * Scan dir for files
     * 
     * @return array
     */
    public function chasil_scanDir(){
        return array_diff(scandir(dirname(__FILE__) . '/files/'), array('..', '.'));
    }
    
    /*
     * Upload file
     * 
     * @return string
     */
    public function chasil_uploadFile(){

        if(isset($_FILES['myFile'])){
            $error = '';
            $file_tmp = $_FILES['myFile']['tmp_name'];
            $file_name = $_FILES['myFile']['name'];
            $file_ext = strtolower(end(explode('.', $_FILES['myFile']['name'])));

            if($file_ext !== "csv") {
                return $error = "<h2 style='color:red'>Nieprawidłowy format pliku. Obsługiwany jest tylko CSV</h2>";
            }
            
            if(empty($error) === true){
                $uploaded=  move_uploaded_file($file_tmp, dirname(__FILE__) . '/files/'.$file_name);

                if(is_wp_error($uploaded)){
                        return $error = "<h2 style='color: red'>Wystąpił błąd: </h2>" . $uploaded->get_error_message();
                }else{
                        return $error = "<h2 style='color: green'>Plik został wgrany!</h2>";
                }
            }
        }
    }
    
    /*
     * Delete file
     * 
     * return @string
     */
    public function chasil_deleteFile(){
        
        if(isset($_GET['delete'])){
            $name = $_GET['file'];
            unlink(dirname(__FILE__) . '/files/' . $name);
            
            wp_redirect("http://wtyczka.pandzia.pl/wp-admin/admin.php?page=chasil_sizeTableMenu&remove=true");
        }
    }
    
    /*
     * Show table in Product site
     */
    public function chasil_sizeTable( $atts ){
        
        $fileName = $atts['name'];
        $tableData = array_map('str_getcsv', file(dirname(__FILE__) . '/files/'. $fileName .'.csv'));
        include(dirname(__FILE__) . '/views/sizeTable.php');
    }
    
    /*
     * Load table style to output view
     */
    public function chasil_loadStyle(){
        wp_enqueue_style('chasil_sizeTableStyle', plugins_url('/size-table/css/sizeTable.css'));
        wp_enqueue_style('chasil_bootstrapStyle', plugins_url('/size-table/css/bootstrap.min.css'));
        wp_enqueue_style('chasil_adminStyle', plugins_url('/size-table/css/adminStyle.css'));
    }
}

new SizeTable();