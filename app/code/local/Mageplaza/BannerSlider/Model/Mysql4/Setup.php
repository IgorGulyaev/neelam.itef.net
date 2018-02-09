<?php
class Mageplaza_BannerSlider_Model_Mysql4_Setup extends Mage_Core_Model_Resource_Setup
{
    public function insertDb()
    {
        $this->insertSimpleSliders();
//        $this->insertAdvanceSliders();

        return $this;
    }

    public function insertAdvanceSliders()
    {
        $filePath = Mage::getBaseDir('media') . DS . 'mageplaza' . DS . 'bannerslider' . DS . 'mysql' . DS . 'setup.sql';
        $sql      = file_get_contents($filePath);
        $sql      = str_replace('{{table_name}}', $this->getTable('bannerslider/advanceslider'), $sql);
        $this->getConnection()->exec($sql);
    }

    public function insertSimpleSliders()
    {
        $this->run("
            insert  into {$this->getTable('bannerslider/banner')}(`banner_id`,`title`,`status`,`type_id`,`source_file`,`fix_size`,`width`,`height`,`link`,`raw_clicks`,`unique_clicks`,`impression`) values (1,'owl1',1,1,'owl1.jpg',2,0,0,'http://www.example.com',0,0,0);
            insert  into {$this->getTable('bannerslider/banner')}(`banner_id`,`title`,`status`,`type_id`,`source_file`,`fix_size`,`width`,`height`,`link`,`raw_clicks`,`unique_clicks`,`impression`) values (2,'owl2',1,1,'owl2.jpg',2,0,0,'http://www.example.com',0,0,0);
            insert  into {$this->getTable('bannerslider/banner')}(`banner_id`,`title`,`status`,`type_id`,`source_file`,`fix_size`,`width`,`height`,`link`,`raw_clicks`,`unique_clicks`,`impression`) values (3,'owl3',1,1,'owl3.jpg',2,0,0,'http://www.example.com',0,0,0);
            insert  into {$this->getTable('bannerslider/banner')}(`banner_id`,`title`,`status`,`type_id`,`source_file`,`fix_size`,`width`,`height`,`link`,`raw_clicks`,`unique_clicks`,`impression`) values (4,'owl4',1,1,'owl4.jpg',2,0,0,'http://www.example.com',0,0,0);
            insert  into {$this->getTable('bannerslider/banner')}(`banner_id`,`title`,`status`,`type_id`,`source_file`,`fix_size`,`width`,`height`,`link`,`raw_clicks`,`unique_clicks`,`impression`) values (5,'owl5',1,1,'owl5.jpg',2,0,0,'http://www.example.com',0,0,0);
            insert  into {$this->getTable('bannerslider/banner')}(`banner_id`,`title`,`status`,`type_id`,`source_file`,`fix_size`,`width`,`height`,`link`,`raw_clicks`,`unique_clicks`,`impression`) values (6,'owl6',1,1,'owl6.jpg',2,0,0,'http://www.example.com',0,0,0);
            insert  into {$this->getTable('bannerslider/banner')}(`banner_id`,`title`,`status`,`type_id`,`source_file`,`fix_size`,`width`,`height`,`link`,`raw_clicks`,`unique_clicks`,`impression`) values (7,'owl7',1,1,'owl7.jpg',2,0,0,'http://www.example.com',0,0,0);
            insert  into {$this->getTable('bannerslider/banner')}(`banner_id`,`title`,`status`,`type_id`,`source_file`,`fix_size`,`width`,`height`,`link`,`raw_clicks`,`unique_clicks`,`impression`) values (8,'flex1',1,1,'kitchen_adventurer_caramel.jpg',2,0,0,'https://www.example.com',0,0,0);
            insert  into {$this->getTable('bannerslider/banner')}(`banner_id`,`title`,`status`,`type_id`,`source_file`,`fix_size`,`width`,`height`,`link`,`raw_clicks`,`unique_clicks`,`impression`) values (9,'flex2',1,1,'kitchen_adventurer_cheesecake_brownie.jpg',2,0,0,'http://www.example.com',0,0,0);
            insert  into {$this->getTable('bannerslider/banner')}(`banner_id`,`title`,`status`,`type_id`,`source_file`,`fix_size`,`width`,`height`,`link`,`raw_clicks`,`unique_clicks`,`impression`) values (10,'flex3',1,1,'kitchen_adventurer_donut.jpg',2,0,0,'http://www.example.com',0,0,0);
            insert  into {$this->getTable('bannerslider/banner')}(`banner_id`,`title`,`status`,`type_id`,`source_file`,`fix_size`,`width`,`height`,`link`,`raw_clicks`,`unique_clicks`,`impression`) values (11,'flex4',1,1,'kitchen_adventurer_lemon.jpg',2,0,0,'http://www.example.com',0,0,0);
            insert  into {$this->getTable('bannerslider/bannerdetail')}(`banner_detail_id`,`banner_id`,`simple_slider_id`,`order`) values (167,3,6,0);
            insert  into {$this->getTable('bannerslider/bannerdetail')}(`banner_detail_id`,`banner_id`,`simple_slider_id`,`order`) values (168,1,6,0);
            insert  into {$this->getTable('bannerslider/bannerdetail')}(`banner_detail_id`,`banner_id`,`simple_slider_id`,`order`) values (169,7,1,0);
            insert  into {$this->getTable('bannerslider/bannerdetail')}(`banner_detail_id`,`banner_id`,`simple_slider_id`,`order`) values (170,6,1,0);
            insert  into {$this->getTable('bannerslider/bannerdetail')}(`banner_detail_id`,`banner_id`,`simple_slider_id`,`order`) values (171,5,1,0);
            insert  into {$this->getTable('bannerslider/bannerdetail')}(`banner_detail_id`,`banner_id`,`simple_slider_id`,`order`) values (172,4,1,0);
            insert  into {$this->getTable('bannerslider/bannerdetail')}(`banner_detail_id`,`banner_id`,`simple_slider_id`,`order`) values (173,3,1,0);
            insert  into {$this->getTable('bannerslider/bannerdetail')}(`banner_detail_id`,`banner_id`,`simple_slider_id`,`order`) values (174,2,1,0);
            insert  into {$this->getTable('bannerslider/bannerdetail')}(`banner_detail_id`,`banner_id`,`simple_slider_id`,`order`) values (175,1,1,0);
            insert  into {$this->getTable('bannerslider/bannerdetail')}(`banner_detail_id`,`banner_id`,`simple_slider_id`,`order`) values (176,11,5,0);
            insert  into {$this->getTable('bannerslider/bannerdetail')}(`banner_detail_id`,`banner_id`,`simple_slider_id`,`order`) values (177,10,5,0);
            insert  into {$this->getTable('bannerslider/bannerdetail')}(`banner_detail_id`,`banner_id`,`simple_slider_id`,`order`) values (178,9,5,0);
            insert  into {$this->getTable('bannerslider/bannerdetail')}(`banner_detail_id`,`banner_id`,`simple_slider_id`,`order`) values (179,8,5,0);
            insert  into {$this->getTable('bannerslider/simpleslider')}(`simple_slider_id`,`simple_slider_type`,`title`,`name`,`enable_title`,`status`,`description`,`store_id`,`position`,`slider_config`,`device_config`,`extend`,`conditions_serialized`) values (1,1,'carousel slider','carousel slider',1,2,'carousel slider','1,2,3','content_sliderTop','{\"autoPlay\":\"1\",\"slideSpeed\":\"2000\",\"navigation\":\"0\",\"pagination\":\"1\",\"stopOnHover\":\"1\",\"lazyLoad\":\"1\",\"autoHeight\":\"1\",\"mouseDrag\":\"0\",\"touchDrag\":\"0\",\"effect\":\"slide\",\"addClassActive\":\"0\"}','{\"device_992\":\"2\",\"device_768\":\"2\",\"device_481\":\"2\",\"device_1200\":\"2\",\"device_less_480\":\"2\"}',NULL,'a:6:{s:4:\"type\";s:32:\"salesrule/rule_condition_combine\";s:9:\"attribute\";N;s:8:\"operator\";N;s:5:\"value\";s:1:\"1\";s:18:\"is_value_processed\";N;s:10:\"aggregator\";s:3:\"all\";}');
            insert  into {$this->getTable('bannerslider/simpleslider')}(`simple_slider_id`,`simple_slider_type`,`title`,`name`,`enable_title`,`status`,`description`,`store_id`,`position`,`slider_config`,`device_config`,`extend`,`conditions_serialized`) values (5,4,'Flex Slider','Flex Slider',1,2,NULL,'1,2,3',NULL,'{\"reverse\":\"1\",\"animationLoop\":\"1\",\"smoothHeight\":\"1\",\"slideshow\":\"0\",\"slideshowSpeed\":\"2000\",\"randomize\":\"1\",\"useCSS\":\"1\",\"minItems\":\"1\",\"maxItems\":\"0\"}',NULL,NULL,'a:6:{s:4:\"type\";s:32:\"salesrule/rule_condition_combine\";s:9:\"attribute\";N;s:8:\"operator\";N;s:5:\"value\";s:1:\"1\";s:18:\"is_value_processed\";N;s:10:\"aggregator\";s:3:\"all\";}');
            insert  into {$this->getTable('bannerslider/simpleslider')}(`simple_slider_id`,`simple_slider_type`,`title`,`name`,`enable_title`,`status`,`description`,`store_id`,`position`,`slider_config`,`device_config`,`extend`,`conditions_serialized`) values (6,2,'Popup Slider','Popup Slider',1,2,NULL,'1,2,3','pop-up','{\"autoPlay\":\"1\",\"slideSpeed\":\"1000\",\"autoSize\":\"1\",\"autoResize\":\"1\",\"fitToView\":\"1\",\"showNavigation\":\"1\"}',NULL,NULL,'a:6:{s:4:\"type\";s:32:\"salesrule/rule_condition_combine\";s:9:\"attribute\";N;s:8:\"operator\";N;s:5:\"value\";s:1:\"1\";s:18:\"is_value_processed\";N;s:10:\"aggregator\";s:3:\"all\";}');

");
    }
}