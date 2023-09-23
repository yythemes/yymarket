<?php
/**
 * @name        Xenice Admin
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2020-03-17
 * @link        https://www.xenice.com/
 * @package     xenice
 */
 
namespace vessel;


class Admin
{
    //private $show_menu = false;
    //private $main_menu = [];
    protected $options  = [];
    protected $defaults = [];

    use Elements;
    
    public function __construct($args = [])
    {
        
        add_action('admin_enqueue_scripts', function(){wp_enqueue_media();});
        isset($args['defaults']) && $this->defaults = $args['defaults'];
        $this->get();

    }
    

	public function __call($method, $args)
    {
        $key = array_search($method, array_column($this->options, 'id'));

        if($key === false){
            throw new \Exception('Call to undefined method ' . get_called_class() . '::' . $method);
        }
        $option = $this->options[$key];
        
        if(isset($option['func'])){ // show custom page
            call_user_func_array($option['func'],[]);
            return;
        }
        
        if(isset($_POST['xenice_option_key']) && check_admin_referer('xenice-options-update')){
            // Delete useless elements
            $data = $_POST;
            unset($data['_wpnonce']);
            unset($data['_wp_http_referer']);
            unset($data['xenice_option_key']);
            if(isset($data['xenice_tab_key'])){
                $tab = $data['xenice_tab_key'];
                unset($data['xenice_tab_key']);
            }
            else{
                $tab = -1;
            }
            
            add_filter('xenice_'.$this->key.'_options_result', [$this,'post']);
            
            if(apply_filters('xenice_'.$this->key.'_options_save', $_POST['xenice_option_key'], $tab, $data)){
                $result = [];
                if($this->set($_POST['xenice_option_key'], $tab,$data)){
                    $this->get();
                    $option = $this->options[$key];
                    $result['return'] = 'success';
                }
                else{
                    $result['return'] = 'error';
                }
                $result['key'] = $_POST['xenice_option_key'];

                apply_filters('xenice_'.$this->key.'_options_result', $result);
            }

        }
        
        if(isset($_POST['return'])){
            $result = [
                'key' => $_POST['key'],
                'return' => $_POST['return'],
                'message' => $_POST['message']??null,
            ];
            
            //$result = Space::call('xenice_options_result_after', $result, $key);
            if($result['return'] == 'success'){
                ?>
                <div class="notice notice-success is-dismissible"> 
            	    <p><strong><?php echo $result['message']??$option['title'].' '.esc_html__('save success', 'onenice')?></strong></p>
                </div>
                <?php
            }
            elseif($result['return'] == 'error'){
                ?>
                <div class="notice notice-error is-dismissible"> 
            	    <p><strong><?php echo $result['message']??$option['title'].' '.esc_html__('save failed', 'onenice')?></strong></p>
                </div>
                <?php
            }
            elseif($result['return'] == 'warning'){
                ?>
                <div class="notice notice-warning is-dismissible"> 
            	    <p><strong><?php echo $result['message']?></strong></p>
                </div>
                <?php
            }
            else{
                ?>
                <div class="notice notice-info is-dismissible"> 
            	    <p><strong><?php echo $result['message']?></strong></p>
                </div>
                <?php
            }
        }
        
        ?>
        <style>
        .wrap .slide-img{
            margin:25px 0 0 0;
            max-height:210px;
        }
        
        .wrap .small-text,.wrap input[type="checkbox"],.wrap input[type="radio"]{
            margin-right:8px;
        }
        
        @media screen and (min-width:768px){
            .wrap .slide-data{
                float:left;
                margin-right:20px;
            }
            .wrap .regular-text{
                margin-right:8px;
            }
            .wrap label textarea{
                vertical-align: top;
            }
        }
        </style>
        <div class="wrap">
            <h2><?php echo $option['title']??''?></h2>
            <?php echo isset($option['desc'])?'<div style="margin-top:8px">'.$option['desc'].'</div>':''?>
            
            <?php
            // show tabs
            if(isset($option['tabs'])){
               
                $page_url = home_url( $_SERVER['PHP_SELF'] . '?page=' . $_GET['page']);
                $current_tab = $_GET['tab']??$option['tabs'][0]['id'];
                $str = '<nav class="nav-tab-wrapper">';
                foreach($option['tabs'] as $key => $tab){
                    if($current_tab == $tab['id']){
                        $str .= '<a href="'.$page_url.'&tab='.$tab['id'].'" class="nav-tab nav-tab-active" >'.$tab['title'].'</a>';
                        if(isset($tab['fields'])){
                            $option['fields'] = $tab['fields'];
                        }
                        elseif(isset($tab['func'])){ // custom page
                            $option['func'] = $tab['func'];
                        }
                        $option['tab_key'] = $key;
                        if(isset($tab['submit'])){
                            $option['submit'] = $tab['submit'];
                        }
                    }
                    else{
                        $str .= '<a href="'.$page_url.'&tab='.$tab['id'].'" class="nav-tab" >'.$tab['title'].'</a>';
                    }
                    
                }
                $str .= '</nav>';
                echo $str;
            }
            
            if(isset($option['func'])){ // show custom page
                call_user_func_array($option['func'],[]);
                return;
            }
            
            if(!isset($option['submit'])){
                $option['submit'] = __('Save Changes', 'onenice');
            }
            
            ?>

            <form method="post" action="" id="xenice_option_form">
                <?php wp_nonce_field('xenice-options-update'); ?>
                <input type="hidden" name="xenice_option_key" value="<?php echo $option['id']?>">
                <?php 
                    if(isset($option['tab_key'])){
                        echo '<input type="hidden" name="xenice_tab_key" value="'.$option['tab_key'].'">';
                    }
                ?>
                <table class="form-table">
                    <tbody>
                    <?php
                    // show fields
                    $str = '';
                    if(isset($option['fields'])){
                        foreach ( $option['fields'] as $field ) {
                            if(isset($field['type']) && $field['type'] == 'data')
                                continue;
                            $style = (isset($field['hide'])&&$field['hide'])?'display:none':'';
                            $top = '<tr style="'.$style.'" class="'.($field['id']??'').'" valign="top"><th scope="row"><label>'.$field['name'].'</label></th><td><p>';
                            if(isset($field['fields'])){
                                $main = '';
                                if(empty($field['inline'])){
                                    foreach($field['fields'] as $f){
                                        $main .= '<p style="margin-bottom:10px">' . call_user_func_array([$this,$f['type']],[$f]) . '</p>';
                                        
                                    }
                                }
                                else{
                                    foreach($field['fields'] as $f){
                                        $main .= '<p style="margin-bottom:10px;margin-right:15px;display:inline-block">' . call_user_func_array([$this,$f['type']],[$f]) . '</p>';
                                        
                                    }
                                }
                                
                            }
                            else{
                                $main = call_user_func_array([$this,$field['type']],[$field]);
                                
                            }
                            
                            $bottom = '</p>';
                            if ( isset($field['desc']) && $field['desc']) {
                                $bottom .= '<p class="description">'.$field['desc'] . '</p>';
                            }
                            $bottom .= '</td></tr>';
                            
                            
                            $str .= $top . $main . $bottom;
                        }
                    }
                    echo $str;
                    ?>
                    </tbody>
                </table>
                <p class="submit">
                    <?php 
                        $buttons = '<input type="submit" class="button-primary" value="'.$option['submit'].'"/>';
                        echo apply_filters('xenice_options_button',$buttons, $option['id'],$option['tab_key']??null);
                    ?>
                </p>
            </form>
        </div>
        <script>
            jQuery(function($){
              $("#xenice_option_form").submit(function(e){
                // image
                $('.xenice-image').each(function(){
                    var value = '';
                    var id = this.name;
                    value += '"url":' + '"' + $('#' + id + '_url').val() + '",';
                    value += '"title":' + '"' + $('#' + id + '_title').val() + '",';
                    value += '"desc":' + '"' + $('#' + id + '_desc').val() + '",';
                    value += '"src":' + '"' + $('#' + id + '_src').val() + '"';
                    value  = '{' + value + '}';
                    this.value = value;
                });
                
                // imgs
                $('.xenice-imgs').each(function(){
                    var value = '';
                    var id = this.name;
                    $('.xenice-imgs-' + id + ' img').each(function(i, e){
                        value  += '"' + $(this).attr("src") + '",';
                    });
                    value = value.substring(0, value.lastIndexOf(','));
                    this.value = '[' + value + ']';
                    
                });
                
                // slide
                $('.xenice-slide').each(function(){
                    var value = '';
                    var id = this.name;
                    $('.xenice-image-' + id ).each(function(i, e){
                        if($('#' + id + '_src_' + i).val() != ''){
                            value  += '{'
                            value += '"url":' + '"' + $('#' + id + '_url_' + i).val() + '",';
                            value += '"title":' + '"' + $('#' + id + '_title_' + i).val() + '",';
                            value += '"desc":' + '"' + $('#' + id + '_desc_' + i).val() + '",';
                            value += '"src":' + '"' + $('#' + id + '_src_' + i).val() + '"';
                            value += '},';
                        }
                    });
                    value = value.substring(0, value.lastIndexOf(','));
                    this.value = '[' + value + ']';
                });
                //e.preventDefault();
              });
              
              <?php echo apply_filters('xenice_'.$this->key.'_add_js', '');?>
            })
            
        </script>
        
    <?php
    }
    
    /**
     * show single page
     */
    public function show()
    {
        if(isset($this->options[0]['id'])){
            call_user_func([$this, $this->options[0]['id']]);
        }
    }
    
    /**
     * return updated results
     */
    public function post($result)
    {
        //$result = Space::call('xenice_options_result_before', $result);
        $str = "<form style='display:none;' id='form_result' name='form_result' method='post' action=''>";
        if(isset($result['message'])){
            $str .= "<input name='message' type='text' value='{$result['message']}' />";
        }
        $str .= "<input name='key' type='text' value='{$result['key']}' />";
        $str .= "<input name='return' type='text' value='{$result['return']}' /></form>";
        $str .= "<script type='text/javascript'>document.form_result.submit();</script>";
        echo $str;
    }
    
    /**
     * get options
     */
    private function get()
    {
        $this->options[] = $this->handle($this->defaults[0]);
    }
    
    /**
     * handle data
     */
    public function handle($options)
    {
        return $options;
    }
    
    /**
     * set options
     */
    private function set($id, $tab, $fields)
    {
        $checkboxs = $this->names($id, $tab, 'checkbox');
        foreach($checkboxs as $checkbox){
            // Checkbox is not submitted when unchecked
            if(!isset($fields[$checkbox])){
                $fields[$checkbox] = false;
            }
            else{
                $fields[$checkbox] = true;
            }
        }
        
        $textareas = $this->names($id, $tab, 'textarea');
        foreach($textareas as $textarea){
            $fields[$textarea] = stripslashes($fields[$textarea]);
        }
        
        $images = $this->names($id, $tab, 'image');
        
        foreach($images as $image){
            $fields[$image] = json_decode(stripslashes($fields[$image]), true);
        }
        
        $slides = $this->names($id, $tab, 'slide');
        
        foreach($slides as $slide){
            $fields[$slide] = json_decode(stripslashes($fields[$slide]), true);
        }
        
        $data = $this->data($id, $tab);
        $data && $fields = array_merge($fields, $data);
        
        return $this->update($id, $tab, $fields);
        //Space::call('xenice_options_set', $id, $fields);
        
        
    }
    
    /**
     * update data
     */
    public function update($id, $tab, $fields)
    {
        return false;
    }
    
    
    /**
     * Get names of the specified type
     */
    public function names($id, $tab, $type)
    {
        $arr = [];
        $key = array_search($id, array_column($this->defaults, 'id'));
        if($tab == -1){
            $fields = $this->defaults[$key]['fields'];
        }
        else{
            $fields = $this->defaults[$key]['tabs'][$tab]['fields'];
        }
        
        foreach($fields as $field){
            if(isset($field['fields'])){
                foreach($field['fields'] as $f){
                    if($f['type'] == $type){
                        $arr[] = $f['id'];
                    }
                }
            }
            else{
                if($field['type'] == $type){
                    $arr[] = $field['id'];
                }
            }
        }
        return $arr;
    }
    
    /**
     * Get data fields
     */
    private function data($id, $tab)
    {
        $key = array_search($id, array_column($this->defaults, 'id'));
        if($tab == -1){
            $fields = $this->defaults[$key]['fields'];
        }
        else{
            $fields = $this->defaults[$key]['tabs'][$tab]['fields'];
        }
        $arr = [];
        foreach($fields as $field){
            if(isset($field['type']) && $field['type'] == 'data'){
                $arr[$field['id']] = $field['value'];
            }
        }
        return $arr;
    }
    
}