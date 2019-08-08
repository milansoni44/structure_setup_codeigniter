<?php 
if(!function_exists('generatedBreadcrumb')){
    function generateBreadcrumb(){
        $ci=&get_instance();
        $i=1;
        $uri = $ci->uri->segment($i);
        $link='
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb"><li><i class="ace-icon fa fa-home home-icon"></i><a href="'.$ci->baseUrl.'">Home</a></li>';

        while($uri != ''){
            $prep_link = '';
            for($j=1; $j<=$i; $j++){
                $prep_link.=$ci->uri->segment($j).'/';
            }

            if($ci->uri->segment($i+1)== ''){
                $link.='<li class="active">';
                $link.=str_replace('_', ' ', ucfirst($ci->uri->segment($i))).'</li>';
            }else{
                $link.='<li><a href="'.site_url($prep_link).'">';
                $link.=str_replace('_',' ', ucfirst($ci->uri->segment($i))).'</a><span class="divider"></span></li>';
            }

            $i++;
            $uri = $ci->uri->segment($i);
        }
        $link .='</ul></div>';
        return $link;
    }
}