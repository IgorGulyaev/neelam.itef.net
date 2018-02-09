<?php

class  Mageplaza_BannerSlider_Block_Adminhtml_Simpleslider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_eventPrefix = 'bannerslider_adminhtml_simpleslider_grid';

    public function __construct()
    {
        parent::__construct();
        $this->setId('simplesliderGrid');
        $this->setDefaultSort('simple_slider_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        //        $this->setSaveParametersInSession(true);

    }

    protected function _addColumnFilterToCollection($column)
    {
        Mage::dispatchEvent($this->_eventPrefix . '_columnfilter', array(
            'collection' => $column
        ));

        return parent::_addColumnFilterToCollection($column);
    }

    protected function _prepareCollection()
    {
        if (!$this->getCollection()) {
            $collection = Mage::getModel('bannerslider/simpleslider')->getCollection();
            if (Mage::registry('useCarouselFilter') === true) {
                $collection->addFieldToFilter('simple_slider_type', Mageplaza_BannerSlider_Model_Simpleslider::TYPE_CAROUSEL);
            } elseif (Mage::registry('usePopupFilter') === true) {
                $collection->addFieldToFilter('simple_slider_type', Mageplaza_BannerSlider_Model_Simpleslider::TYPE_POPUP);

            } elseif (Mage::registry('useNoteFilter') === true) {
                $collection->addFieldToFilter('simple_slider_type', Mageplaza_BannerSlider_Model_Simpleslider::TYPE_NOTE);

            } elseif (Mage::registry('useFlexFilter') === true) {
                $collection->addFieldToFilter('simple_slider_type', Mageplaza_BannerSlider_Model_Simpleslider::TYPE_FLEX);
            }

            Mage::dispatchEvent($this->_eventPrefix . '_collection', array(
                'collection' => $collection
            ));

            $this->setCollection($collection);
        }

        parent::_prepareCollection();
        foreach ($collection as $item) {
            if ($storeIds = $item->getStoreId()) {
                $item->setStoreId(explode(',', $storeIds));
            }
        }

        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn('simple_slider_id', array(
            'header' => Mage::helper('bannerslider')->__('ID'),
            'align'  => 'right',
            'width'  => '50px',
            'index'  => 'simple_slider_id',
        ));
        $this->addColumn('name', array(
            'header' => Mage::helper('bannerslider')->__('Name'),
            'align'  => 'left',
            'index'  => 'name',
        ));
        $this->addColumn('title', array(
            'header' => Mage::helper('bannerslider')->__('Title'),
            'align'  => 'left',
            'index'  => 'title',
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

            ));
        }
        if ($this->getRequest()->getActionName() != 'popup') {
            $this->addColumn('position', array(
                'header'  => Mage::helper('bannerslider')->__('Position'),
                'align'   => 'left',
                'width'   => '80px',
                'index'   => 'position',
                'type'    => 'options',
                'options' => Mage::getSingleton('bannerslider/position')->getPositionOptions()
            ));
        }
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

        $this->addColumn('edit_action',
            array(
                'header'    => Mage::helper('bannerslider')->__('Action'),
                'width'     => '40',
                'align'     => 'center',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('bannerslider')->__('Edit'),
                        'url'     => array(
                            'base'   => '*/adminhtml_simpleslider/edit',
                            'params' => array('type' => $this->getRequest()->getActionName()
                            )),
                        'field'   => 'id'
                    )
                ),
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
                            'base'   => '*/adminhtml_simpleslider/preview',
                            'params' => array('type' => $this->getRequest()->getActionName()
                            )),
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


        $this->addExportType('*/*/exportCsv', Mage::helper('bannerslider')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('bannerslider')->__('Excel XML'));


        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('simple_slider_id');
        $this->getMassactionBlock()->setFormFieldName('simpleslider');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'   => Mage::helper('bannerslider')->__('Delete'),
            'url'     => $this->getUrl('*/*/massDelete', array('type' => $this->getRequest()->getActionName())),
            'confirm' => Mage::helper('bannerslider')->__('Are you sure?')
        ));
        $statuses = Mage::getSingleton('bannerslider/status')->getOptionArray(false);
        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
            'label'      => Mage::helper('bannerslider')->__('Change status'),
            'url'        => $this->getUrl('*/*/massStatus', array('type' => $this->getRequest()->getActionName())),
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

        return $this;
    }

    public function getGridUrl()
    {
        if (Mage::registry('useCarouselFilter')) {
            return $this->getUrl(
                '*/*/' . (Mage::registry('useCarouselFilter') ? 'carousel' : ''), array(
                    '_current' => true
                ));
        }
        if (Mage::registry('usePopupFilter')) {
            return $this->getUrl(
                '*/*/' . (Mage::registry('usePopupFilter') ? 'popup' : ''), array(
                    '_current' => true
                ));
        }
        if (Mage::registry('useNoteFilter')) {
            return $this->getUrl(
                '*/*/' . (Mage::registry('useNoteFilter') ? 'note' : ''), array(
                    '_current' => true
                ));
        }
        if (Mage::registry('useFlexFilter')) {
            return $this->getUrl(
                '*/*/' . (Mage::registry('useFlexFilter') ? 'flex' : ''), array(
                    '_current' => true
                ));
        }
    }

    public function getRowUrl($row)
    {
        $ret = $this->getRequest()->getActionName();

        $id = $row->getSimpleSliderId();

        return $this->getUrl('*/*/edit', array(
            'id'   => $id,
            'type' => $ret
        ));
    }

    protected function _filterStoreCondition($collection, $column)
    {
        $value = $column->getFilter()->getValue();
        if (!is_null(@$value) && @$value != 0) {
            $collection->addFieldToFilter($column->getIndex(), array('finset' => $value));
        }
    }

}