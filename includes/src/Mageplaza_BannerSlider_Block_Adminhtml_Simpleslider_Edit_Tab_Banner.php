<?php
class Mageplaza_BannerSlider_Block_Adminhtml_Simpleslider_Edit_Tab_Banner extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('bannergrid');
        $this->setDefaultSort('banner_id');
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('id')) {
            $this->setDefaultFilter(array('in_custom' => 1));
        }
    }


    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bannerslider/banner')->getCollection()
            ->addFieldToFilter('status', 1);
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('in_banner', array(
            'header_css_class' => 'a-center',
            'type'             => 'checkbox',
            'name'             => 'in_banner',
            'values'           => $this->_getSelectedBanners(),
            'field_name'       => 'in_banner[]',
            'align'            => 'center',
            'index'            => 'banner_id',
        ));

        $this->addColumn('banner_id', array(
            'header' => Mage::helper('bannerslider')->__('ID'),
            'width'  => '80px',
            'index'  => 'banner_id',
        ));

        $this->addColumn('title_banner', array(
            'header' => Mage::helper('bannerslider')->__('Name'),
            'index'  => 'title'
        ));
        $this->addColumn('type_id', array(
            'header'   => Mage::helper('bannerslider')->__('Type'),
            'width'    => '100px',
            'index'    => 'type_id',
            'type'     => 'options',
            'align'    => 'center',
            'renderer' => 'bannerslider/adminhtml_banner_renderer_image',
            'options'  => Mage::getModel('bannerslider/banner')->getTypeArray(),
        ));



        $this->addColumn('order', array(
            'header'   => Mage::helper('bannerslider')->__('Order'),
            'width'   => '120px',
            'index'    => 'order',
            'renderer' => 'bannerslider/adminhtml_renderer_order',
            'editable' => true,
        ));

        $this->addColumn('status_banner', array(
            'header'  => Mage::helper('bannerslider')->__('Status'),
            'align'   => 'left',
            'width'   => '80px',
            'index'   => 'status',
            'type'    => 'options',
            'options' => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
        ));

        $this->addColumn('action_banner', array(
            'header'   => Mage::helper('bannerslider')->__('Edit'),
            'renderer' => 'bannerslider/adminhtml_renderer_detail',
            'index'    => 'action_banner',
            'width'   => '80px',
        ));


        return parent::_prepareColumns();
    }


    public function getRowUrl($row)
    {
        return '';
    }

    public function getGridUrl()
    {
        return $this->getUrl(
            '*/*/grid', array(
            '_current' => true
        ));
    }

    protected function _getSelectedBanners()
    {
        $sliderId = $this->getRequest()->getParam('id');
        if (!isset($sliderId)) {
            return array();
        }

        $bannerDetails = Mage::getModel('bannerslider/bannerdetail')->getCollection()
            ->addFieldToFilter('simple_slider_id', $sliderId);
        $bannerIdArr   = array();
        foreach ($bannerDetails as $bannerDetail) {
            $bannerIdArr[] = $bannerDetail->getBannerId();
        }

        return $bannerIdArr;
    }
}