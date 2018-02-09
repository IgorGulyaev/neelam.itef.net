<?php

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * create bannerslider table
 */
/** table sky_simple_slider */
$installer->getConnection()->dropTable($installer->getTable('bannerslider/simpleslider'));
$table = $installer->getConnection()
    ->newTable($installer->getTable('bannerslider/simpleslider'))
    ->addColumn('simple_slider_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary'  => true,
    ), 'Simple Slider ID')
    ->addColumn('simple_slider_type', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '1',
    ), 'Simple Slider Type')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
        'default'  => '',
    ), 'Title')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
        'default'  => '',
    ), 'Name')
    ->addColumn('enable_title', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '1',
    ), 'Show Title')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '1',
    ), 'Status')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => true,
    ), 'Description')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable' => false,
    ), 'Store ID')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => true,
        'default'  => '',
    ), 'Position')
    ->addColumn('slider_config', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable' => true,
    ), 'Slider Config')
    ->addColumn('device_config', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable' => true,
    ), 'Device Config')
    ->addColumn('extend', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable' => true,
    ), 'Extend')
    ->addColumn('conditions_serialized', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable' => true,
    ), 'Condition Serialized')
    ->setComment('Simple Slider Table');
$installer->getConnection()->createTable($table);
/** table sky_banner */
$installer->getConnection()->dropTable($installer->getTable('bannerslider/banner'));
$table = $installer->getConnection()
    ->newTable($installer->getTable('bannerslider/banner'))
    ->addColumn('banner_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary'  => true,
    ), 'Banner ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
        'default'  => '',
    ), 'Title')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '1',
    ), 'Status')
    ->addColumn('type_id', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Type')
    ->addColumn('source_file', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
        'default'  => '',
    ), 'Source File')
    ->addColumn('fix_size', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '2',
    ), 'Fix Size')
    ->addColumn('width', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Width')
    ->addColumn('height', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Height')
    ->addColumn('link', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
        'default'  => '',
    ), 'Link')
    ->addColumn('raw_clicks', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Raw Clicks')
    ->addColumn('unique_clicks', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Unique Clicks')
    ->addColumn('impression', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Impression')
    ->setComment('Banner Table ');
$installer->getConnection()->createTable($table);
/** table sky_bannerdetail */
$installer->getConnection()->dropTable($installer->getTable('bannerslider/bannerdetail'));
$table = $installer->getConnection()
    ->newTable($installer->getTable('bannerslider/bannerdetail'))
    ->addColumn('banner_detail_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary'  => true,
    ), 'Banner Detail ID')
    ->addColumn('banner_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Banner ID')
    ->addColumn('simple_slider_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Simple Slider Id')
    ->addColumn('order', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Order')
    ->addForeignKey($installer->getFkName('bannerslider/bannerdetail', 'banner_id', 'bannerslider/banner', 'banner_id'),
        'banner_id', $installer->getTable('bannerslider/banner'), 'banner_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('bannerslider/bannerdetail', 'simple_slider_id', 'bannerslider/simpleslider', 'simple_slider_id'),
        'simple_slider_id', $installer->getTable('bannerslider/simpleslider'), 'simple_slider_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Banner Slider Detail');
$installer->getConnection()->createTable($table);

/** table sky_banner_traffic */
$installer->getConnection()->dropTable($installer->getTable('bannerslider/traffic'));
$table = $installer->getConnection()
    ->newTable($installer->getTable('bannerslider/traffic'))
    ->addColumn('traffic_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary'  => true,
    ), 'Traffic ID')
    ->addColumn('banner_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Banner ID')
    ->addColumn('ip_address', Varien_Db_Ddl_Table::TYPE_VARCHAR, 40, array(
        'nullable' => false,
        'default'  => '',
    ), 'Ip Address')
    ->addColumn('visit_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable' => true,
    ), 'Visit At')
    ->addColumn('type_id', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Type 1: click, Type 2 Impression')
    ->addColumn('http_referer', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
        'default'  => '',
    ), 'Referer')
    ->addForeignKey($installer->getFkName('bannerslider/traffic', 'banner_id', 'bannerslider/banner', 'banner_id'),
        'banner_id', $installer->getTable('bannerslider/banner'), 'banner_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Traffic Banner');
$installer->getConnection()->createTable($table);
/** table sky_banner_traffic */
$installer->getConnection()->dropTable($installer->getTable('bannerslider/advanceslider'));
$table = $installer->getConnection()
    ->newTable($installer->getTable('bannerslider/advanceslider'))
    ->addColumn('advance_slider_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary'  => true,
    ), 'Advance Slider Id')
    ->addColumn('is_default', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => 0,
    ), 'Is Default')
    ->addColumn('select_slider', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Select Slider')
    ->addColumn('js_text', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable' => true,
    ), 'Javascript Text')
    ->addColumn('css_text', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable' => true,
    ), 'Css Text')
    ->addColumn('html_text', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable' => true,
    ), 'Html Text')
    ->addColumn('banner_html', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable' => true,
    ), 'Html Text')
    ->addColumn('status', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default'  => '1',
    ), 'Status')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
        'default'  => '',
    ), 'Name')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable' => false,
    ), 'Store ID')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
        'default'  => '',
    ), 'Position')
    ->addColumn('prefix', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable' => true,
    ), 'Prefix Text')
    ->addColumn('suffix', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable' => true,
    ), 'Suffix Text')
    ->addColumn('conditions_serialized', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        'nullable' => true,
    ), 'Condition Serialized')

    ->setComment('Advance Slider Table');
$installer->getConnection()->createTable($table);
//Insert Simple Data
$installer->insertDb();
//End Insert


if (version_compare(Mage::getVersion(), '1.9.2.1', '>')) {
    $blocks = array(
        'bannerslider/simpleslider',
        'bannerslider/advanceslider',
    );
    foreach ($blocks as $_block) {
        $data = array(
            'block_name' => $_block,
            'is_allowed' => 1
        );
        try {
            $model = Mage::getModel('admin/block')->load($_block);
            if ($model->getId()) {
                return;
            }
            $model->setData($data);
            $model->save();
        } catch (Exception $e) {
            Mage::log($e->getMessage());
        }
    }
}



$installer->endSetup();

