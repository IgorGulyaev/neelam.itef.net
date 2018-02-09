<?php
class Mageplaza_BannerSlider_Block_Adminhtml_Advanceslider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('advancesliderGrid');
        $this->setDefaultSort('advance_slider_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * prepare collection for block to display
     *
     * @return Mageplaza_BannerSlider_Block_Adminhtml_Bannerslider_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bannerslider/advanceslider')->getCollection()
        ->addFieldToFilter('is_default',0);
        $this->setCollection($collection);
        parent::_prepareCollection();
        foreach ($collection as $item) {
            if ($storeIds = $item->getStoreId()) {
                $item->setStoreId(explode(',', $storeIds));
            }
        }

        return $this;
    }

    /**
     * prepare columns for this grid
     *
     * @return Mageplaza_BannerSlider_Block_Adminhtml_Bannerslider_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('advance_slider_id', array(
            'header' => Mage::helper('bannerslider')->__('ID'),
            'align'  => 'right',
            'width'  => '50px',
            'index'  => 'advance_slider_id',
        ));

        $this->addColumn('name', array(
            'header' => Mage::helper('bannerslider')->__('Name'),
            'align'  => 'left',
            'index'  => 'name',
            'width'  => '150px',
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'                    => Mage::helper('bannerslider')->__('Store View'),
                'index'                     => 'store_id',
                'type'                      => 'store',
                'align'                     => 'center',
                'store_all'                 => true,
                'store_view'                => true,
                'sortable'                  => true,
                'filter_condition_callback' => array($this, '_filterStoreCondition'),
                'width'   => '150px',
            ));
        }

        $this->addColumn('position', array(
            'header'  => Mage::helper('bannerslider')->__('Position'),
            'align'   => 'left',
            'width'   => '180px',
            'index'   => 'position',
            'type'    => 'options',
            'options' => Mage::getSingleton('bannerslider/position')->getPositionOptions()
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
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('bannerslider')->__('Edit'),
                        'url'     => array('base' => '*/*/edit'),
                        'field'   => 'id'
                    )),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
            ));
        $this->addColumn('preview_action',
            array(
                'header'    => Mage::helper('bannerslider')->__('Preview'),
                'width'     => '40',
                'align'     => 'center',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('bannerslider')->__('Preview'),
                        'target'  => "_blank",
                        'url'     => array(
                            'base'   => '*/adminhtml_advanceslider/preview',
                            'params' => array('type' => 'advance'
                            )),
                        'field'   => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
            ));
        $this->addExportType('*/*/exportCsv', Mage::helper('bannerslider')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('bannerslider')->__('XML'));

        return parent::_prepareColumns();
    }

    /**
     * prepare mass action for this grid
     *
     * @return Mageplaza_BannerSlider_Block_Adminhtml_Bannerslider_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('advance_slider_id');
        $this->getMassactionBlock()->setFormFieldName('bannerslider');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'   => Mage::helper('bannerslider')->__('Delete'),
            'url'     => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('bannerslider')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('bannerslider/status')->getOptionArray();

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
                ))
        ));

        return $this;
    }

    protected function _filterStoreCondition($collection, $column)
    {
        $value = $column->getFilter()->getValue();
        if (!is_null(@$value) && @$value != 0) {
            $collection->addFieldToFilter($column->getIndex(), array('finset' => $value));
        }
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}