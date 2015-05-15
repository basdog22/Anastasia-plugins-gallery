<?php

register_header_elements(array(
    'gallery::hooks/header'
));

register_footer_elements(array(
    'gallery::hooks/footer'
));

register_shortcode('gallery',function($shortcode,$content,$object,$c){
    $files = \File::allFiles(asset_path('images').'/'.$shortcode->dir);

    $width = ($shortcode->width)?$shortcode->width:80;

    $html = '
    <div id="blueimp-gallery" class="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body next"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left prev">
                        <i class="glyphicon glyphicon-chevron-left"></i>
                        '.t('gallery::strings.previous').'
                    </button>
                    <button type="button" class="btn btn-primary next">
                        '.t('gallery::strings.next').'
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
    <div id="links" class="links thumb">';
    foreach($files as $image){
        $path = str_replace(files_path().'/','',(string)$image);
        $image = \Image::wherePath($path)->first();
        if(!is_null($image)){
            $html .= '<a class="pull-left thumbnail" title="'.$image->title.'" href="'.$image->url().'" data-gallery>
                    <img alt="'.$image->title.'" src="'.$image->url($width).'" class="img-responsive">
                </a>';
        }


    }
    $html .= '</div>';
    return $html;
},'Attributes: <ul><li>dir (default: /)</li><li>width (The width of the thumbnailes in pixels. default: 80)</li></ul><br/>Show the specified directory as a gallery. The directory should exist in the your images folder.');
