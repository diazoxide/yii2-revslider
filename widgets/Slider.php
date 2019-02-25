<?php

namespace diazoxide\revslider\widgets;

use diazoxide\revslider\Module\assets\SliderRevolutionAsset;
use yii\bootstrap\Html;

class Slider extends \yii\bootstrap\Widget
{
    private $_slider_id;
    private $_version = '5.4.8.1';
    public $items;
    public $wrapperStyle;
    public $wrapperData;
    public $sliderStyle;
    public $sliderData;
    public $config;

    public function init()
    {

        SliderRevolutionAsset::register($this->getView());

        parent::init();

        $this->_slider_id = "rev_slider_" . $this->id . "_1";
        $sliderID = $this->_slider_id;
        $config = json_encode($this->config);
        $itemsList = $this->buildItemsList($this->items);
        $slider = $this->buildSlider($itemsList);
        $wrapper = $this->buildWrapper($slider);
        echo $wrapper;

        $script = <<< JS
        var $sliderID,
			tpj;	
			(function() {			
				if (!/loaded|interactive|complete/.test(document.readyState)) document.addEventListener("DOMContentLoaded",onLoad); else onLoad();	
				function onLoad() {				
					if (tpj===undefined) { tpj = jQuery; if("on" == "on") tpj.noConflict();}
					if(tpj("#{$this->_slider_id}").revolution == undefined){
						revslider_showDoubleJqueryError("#{$this->_slider_id}");
					}else{
						$sliderID = tpj("#{$this->_slider_id}").show().revolution($config);
					}; /* END OF revapi call */
					
				}; /* END OF ON LOAD FUNCTION */
			}()); /* END OF WRAPPING FUNCTION */
JS;
        $this->view->registerJs($script);

        $script2 = <<<JS
function setREVStartSize(e){									
	try{ e.c=jQuery(e.c);var i=jQuery(window).width(),t=9999,r=0,n=0,l=0,f=0,s=0,h=0;
		if(e.responsiveLevels&&(jQuery.each(e.responsiveLevels,function(e,f){f>i&&(t=r=f,l=e),i>f&&f>r&&(r=f,n=e)}),t>r&&(l=n)),f=e.gridheight[l]||e.gridheight[0]||e.gridheight,s=e.gridwidth[l]||e.gridwidth[0]||e.gridwidth,h=i/s,h=h>1?1:h,f=Math.round(h*f),"fullscreen"==e.sliderLayout){var u=(e.c.width(),jQuery(window).height());if(void 0!=e.fullScreenOffsetContainer){var c=e.fullScreenOffsetContainer.split(",");if (c) jQuery.each(c,function(e,i){u=jQuery(i).length>0?u-jQuery(i).outerHeight(!0):u}),e.fullScreenOffset.split("%").length>1&&void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0?u-=jQuery(window).height()*parseInt(e.fullScreenOffset,0)/100:void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0&&(u-=parseInt(e.fullScreenOffset,0))}f=u}else void 0!=e.minHeight&&f<e.minHeight&&(f=e.minHeight);e.c.closest(".rev_slider_wrapper").css({height:f})					
	}catch(d){console.log("Failure at Presize of Slider:"+d)}						
};
JS;

        $this->view->registerJs($script2);

        $css = <<<CSS
#{$this->_slider_id} .gyges-2 .tp-tab{opacity:1; padding:10px; box-sizing:border-box; font-family:"roboto",sans-serif; border-bottom:1px solid rgba(255,255,255,0.15)}#{$this->_slider_id} .gyges-2 .tp-tab-image{width:60px; height:60px;  max-height:100%;  max-width:100%; position:relative; display:inline-block; float:left}#{$this->_slider_id} .gyges-2 .tp-tab-content{background:rgba(0,0,0,0);   position:relative;  padding:15px 15px 15px 85px;  left:0px;  overflow:hidden;  margin-top:-15px;  box-sizing:border-box;  color:rgba(51,51,51,0);  display:inline-block;  width:100%;  height:100%; position:absolute}#{$this->_slider_id} .gyges-2 .tp-tab-date{display:block; color:rgba(255,255,255,0.5); font-weight:500; font-size:12px; margin-bottom:0px}#{$this->_slider_id} .gyges-2 .tp-tab-title{display:block;   text-align:left;  color:rgba(255,255,255,1);  font-size:14px;  font-weight:500;  text-transform:none;  line-height:17px}#{$this->_slider_id} .gyges-2 .tp-tab:hover,#{$this->_slider_id} .gyges-2 .tp-tab.selected{background:rgba(0,0,0,0.51)}#{$this->_slider_id} .gyges-2 .tp-tab-mask{}@media only screen and (max-width:960px){}@media only screen and (max-width:768px){}
CSS;
        $this->view->registerCss($css);


    }

    public function buildWrapper($slider)
    {

        $this->wrapperData['alias'] = "home";
        $this->wrapperData['source'] = "posts";
        return Html::tag('div', $slider, [
            'id' => $this->_slider_id . "_wrapper",
            "class" => "rev_slider_wrapper fullwidthbanner-container",
            "style" => $this->wrapperStyle,
            "data" => $this->wrapperData,
        ]);
    }

    public function buildSlider($itemsList)
    {
        //		<div id="rev_slider_1_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.4.8.1">
        $this->sliderData['version'] = $this->_version;
        return Html::tag('div', $itemsList, [
            'id' => $this->_slider_id,
            "class" => "rev_slider fullwidthbanner",
            "style" => $this->sliderStyle,
            "data" => $this->sliderData,
        ]);
    }

    public function buildItemsList($items)
    {
        //<li data-index="rs-107918" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="300"  data-thumb="assets/963637-100x50.jpg"  data-rotate="0"  data-saveperformance="off"  data-title="Սերժ Սարգսյանը Մարտի 1-ի գործով մեղադրյալի կարգավիճակ չունի. ՀՔԾ" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
        return Html::ul($items, ['item' => function ($item, $index) {
            $data = isset($item['data']) ? $item['data'] : [];
            $data['index'] = "rs-" . $index;
            return Html::tag(
                'li',
                $this->buildItem($item, $index),
                [
                    'class' => 'post',
                    'data' => $data
                ]
            );
        }]);

    }

    public function buildItem($data, $index)
    {
        /*
         * MAIN IMAGE
		 * <img src="assets/963637.jpg"  alt="" title="963637"  width="670" height="450" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="off" class="rev-slidebg" data-no-retina>
         * */
        $mainImageData = isset($data['mainImage']) ? $data['mainImage'] : [];
        $mainImageData['bgposition'] = 'center center';
        $mainImageData['bgfit'] = 'cover';
        $mainImageData['bgrepeat'] = 'no-repeat';
        $mainImage = Html::img($data['mainImage']['src'], [
            'data' => $mainImageData,
            'class' => "rev-slidebg",
            'alt' => $index,
            'width' => "670",
            'height' => "450",
        ]);

        $layersHtml = "";
        foreach ($data['layers'] as $layerIndex => $layer) {
            $layersHtml .= $this->buildLayer($index, $layerIndex, $layer);
        }

        return $mainImage . $layersHtml;
    }

    public function buildLayer($itemIndex, $layerIndex, $data)
    {
        $layerIndex++;
        return Html::tag("div", isset($data['content']) ? $data['content'] : "", [
            "id" => "slide-$itemIndex-layer-$layerIndex",
            "class" => isset($data['class']) ? $data['class'] : "",
            'data' => isset($data['data']) ? $data['data'] : [],
            'style'=>isset($data['style']) ? $data['style'] : "",
        ]);
    }
}
