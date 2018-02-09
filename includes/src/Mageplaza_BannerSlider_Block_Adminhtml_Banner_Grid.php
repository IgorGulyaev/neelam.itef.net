<?php
class Mageplaza_BannerSlider_Block_Adminhtml_Banner_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('bannerGrid');
        $this->setDefaultSort('banner_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }


    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bannerslider/banner')->getCollection();
//        $collection->getSelect()->joinLeft(
//            array('sp' => $collection->getTable('bannerslider/simpleslider')),
//            'main_table.simple_slider_id=sp.simple_slider_id',array('sp.name'));
//        Mage::dispatchEvent($this->_eventPrefix . '_collection', array(
//            'collection' => $collection
//        ));
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }
    protected function _addColumnFilterToCollection($column)
    {
        Mage::dispatchEvent($this->_eventPrefix . '_columnfilter', array(
            'collection' => $column
        ));

        return parent::_addColumnFilterToCollection($column);
    }
    protected function _prepareColumns()
    {
        $this->addColumn('banner_id', array(
            'header' => Mage::helper('bannerslider')->__('ID'),
            'align'  => 'right',
            'width'  => '50px',
            'index'  => 'banner_id',
        ));

        $this->addColumn('title', array(
            'header' => Mage::helper('bannerslider')->__('Title'),
            'align'  => 'left',
            'index'  => 'title',
        ));


        $this->addColumn('link', array(
            'header'   => Mage::helper('bannerslider')->__('Link'),
            'index'    => 'link',
            'renderer' => 'bannerslider/adminhtml_banner_renderer_link',
        ));
//        $this->addColumn('name', array(
//            'header'   => Mage::helper('bannerslider')->__('Simple Slider'),
//            'index'    => 'name',
//        ));
//        $this->addColumn('advance_slider_id', array(
//            'header'   => Mage::helper('bannerslider')->__('Advance Slider ID'),
//            'index'    => 'advance_slider_id',
//        ));


        $this->addColumn('type_id', array(
            'header'   => Mage::helper('bannerslider')->__('Type'),
            'width'    => '100px',
            'index'    => 'type_id',
            'type'     => 'options',
            'align'    => 'center',
            'renderer' => 'bannerslider/adminhtml_banner_renderer_image',
            'options'  => Mage::getModel('bannerslider/banner')->getTypeArray(),
        ));

        $this->addColumn('status', array(
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

        $this->addColumn('action',
            array(
                'header'    => Mage::helper('bannerslider')->__('Action'),
                'width'     => '40',
                'align'     => 'center',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('bannerslider')->__('Edit'),
                        'url'     => array('base' => '*/*/edit'),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
            ));

        Mage::dispatchEvent($this->_eventPrefix . '_column', array(
            'grid' => $this
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('customer')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('customer')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    /**
     * prepare mass action for this grid
     *
     * @return Mageplaza_BannerSlider_Block_Adminhtml_Bannerslider_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('banner_id');
        $this->getMassactionBlock()->setFormFieldName('banner');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'   => Mage::helper('bannerslider')->__('Delete'),
            'url'     => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('bannerslider')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('bannerslider/banner')->getOptionArray(false);
        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label'      => Mage::helper('bannerslider')->__('Change status'),
            'url'        => $this->getUrl('*/*/massStatus', array('_current' => true)),
            'additional' => array(
                'visibility' => array(
                    'name'   => 'status',
                    'type'   => 'select',
                    'class'  => 'required-entry',
                    'label'  => Mage::helper('bannerslider')->__('Status'),
                    'values' => $statuses
                )
            )
        ));

        Mage::dispatchEvent($this->_eventPrefix . '_massaction', array(
            'grid'  => $this,
            'block' => $this->getMassactionBlock()
        ));

        return $this;
    }

    /**
     * get url for each row in grid
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
    protected function _filterStoreCondition($collection, $column)
    {
        $value = $column->getFilter()->getValue();
        if (!is_null(@$value) && @$value != 0) {
            $collection->addFieldToFilter($column->getIndex(), array('finset' => $value));
        }
    }
}