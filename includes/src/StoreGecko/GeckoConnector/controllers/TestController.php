<?php

class StoreGecko_GeckoConnector_TestController extends Mage_Core_Controller_Front_Action
{
    private function authenticateUser($licenseKey)
    {
        $isExtensionEnabled = (bool)Mage::getStoreConfig('geckoconnector/general/enabled');
        if ($isExtensionEnabled) {
            $internalLicenseKey = Mage::getStoreConfig('geckoconnector/general/licenseskey');
            if ($internalLicenseKey == $licenseKey) {
                return true;
            }
        }
        echo json_encode(array('message' => 'Invalid license key or extension is not enabled.'));
        return false;
    }

    public function checkStatusAction()
    {
        $licenseKey = $this->getRequest()->getParam('license_key');
        $isExtensionEnabled = (bool)Mage::getStoreConfig('geckoconnector/general/enabled');
        $internalLicenseKey = Mage::getStoreConfig('geckoconnector/general/licenseskey');

        $status = [
            'enabled' => $isExtensionEnabled,
            'valid_credentials' => (strcmp($licenseKey, $internalLicenseKey) === 0)
        ];

        $this->getResponse()
            ->setHeader('Content-type', 'application/json')
            ->setBody(json_encode($status));
    }

    public function targetsAction()
    {
        $result = array(
            'websites' => array(),
            'groups' => array(),
            'stores' => array()
        );

        $websites = Mage::app()->getWebsites();
        foreach ($websites as $website) {
            $result['websites'][] = $website->getData();

            $groups = $website->getGroups();
            foreach ($groups as $group) {
                $result['groups'][] = $group->getData();

                $stores = $group->getStores();
                foreach ($stores as $store) {
                    $result['stores'][] = $store->getData();
                }
            }
        }

        $storesCollectionJson = json_encode($result);

        $this->getResponse()
            ->setHeader('Content-type', 'application/json')
            ->setBody($storesCollectionJson);
    }

    public function attributeSetsAction()
    {
        $entityTypeId = Mage::getModel('eav/entity')
            ->setType('catalog_product')
            ->getTypeId();

        $attributeSetCollection = Mage::getModel('eav/entity_attribute_set')
            ->getCollection()
            ->setEntityTypeFilter($entityTypeId)
            ->getData();

        $attributeSetCollectionJson = json_encode($attributeSetCollection);

        $this->getResponse()
            ->setHeader('Content-type', 'application/json')
            ->setBody($attributeSetCollectionJson);
    }

    public function attributesAction()
    {
        $productAttributes = Mage::getResourceModel('catalog/product_attribute_collection');

        $attributes = array();

        foreach ($productAttributes as $productAttr) {
            $attributes[] = $productAttr->getData();
        }

        $attributeCollectionJson = json_encode($attributes);
        $this->getResponse()
            ->setHeader('Content-type', 'application/json')
            ->setBody($attributeCollectionJson);
    }

    public function categoriesAction()
    {
        $categoriesArray = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('name')
//        ->addAttributeToSort('path', 'asc')
//        ->addFieldToFilter('path', array('like'=> "1/$rootId/%"))
            ->load()
            ->toArray();

        $categoriesCollectionJson = json_encode(
            array_values($categoriesArray)
        );

        $this->getResponse()
            ->setHeader('Content-type', 'application/json')
            ->setBody($categoriesCollectionJson);
    }

    public function dropdownValuesAction()
    {
        $tablePrefix = LegacyHelperFunctions::getDBTablePrefix();
        $values = LegacyMagentoDatabase::ReadQuery(
            "SELECT value_id, " . $tablePrefix . "eav_attribute_option.option_id, attribute_id, sort_order, store_id, " . $tablePrefix . "eav_attribute_option_value.value
			FROM " . $tablePrefix . "eav_attribute_option
			JOIN " . $tablePrefix . "eav_attribute_option_value
			ON " . $tablePrefix . "eav_attribute_option_value.option_id = " . $tablePrefix . "eav_attribute_option.option_id"
        );

        $this->getResponse()
            ->setHeader('Content-type', 'application/json')
            ->setBody(json_encode($values));
    }

    public function attributesToAttributeSetsMappingAction()
    {
        $allAttributes = array();

        // Get all attribute sets
        $entityTypeId = Mage::getModel('eav/entity')
            ->setType('catalog_product')
            ->getTypeId();

        $attributeSetCollection = Mage::getModel('eav/entity_attribute_set')
            ->getCollection()
            ->setEntityTypeFilter($entityTypeId)
            ->getData();

        // Get all attributes
        $productAttributes = Mage::getResourceModel('catalog/product_attribute_collection');

        $attributes = array();
        foreach ($productAttributes as $attribute) {
            $attributeId = $attribute->getData('attribute_id');

            $attributes[$attributeId] = $attributeId;
        }

        // Map attributes to attribute set
        foreach ($attributeSetCollection as $i => $attributeSet) {

            $attributeSetId = $attributeSet['attribute_set_id'];
            $attributeSetAttributes = Mage::getModel('catalog/product_attribute_api')
                ->items($attributeSetId);

            $allAttributes[$attributeSetId] = array();

            foreach ($attributeSetAttributes as $attribute) {
                $attributeId = $attribute['attribute_id'];

                $allAttributes[$attributeSetId][] = $attributes[$attributeId];
            }
        }

        $this->getResponse()
            ->setHeader('Content-type', 'application/json')
            ->setBody(json_encode($allAttributes));
    }

    private function updateProduct($productId, $storeId, $productValues)
    {
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
        $product = Mage::getModel('catalog/product')->load($productId);

        foreach ($productValues as $attributeCode => $value) {
//            if ($value) {
            $product->setStoreId($storeId)->setData($attributeCode, $value);
//            }
        }

        $product->save();
    }

    private function updateStockInventory($productId, $stockInventoryValues)
    {
        $stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($productId);

        $stockInventoryValues['manage_stock'] = true;

        foreach ($stockInventoryValues as $attributeCode => $value) {
            $stockItem->setData($attributeCode, $value);
        }

        $stockItem->save();
    }

    protected function saveImageFromUrl($img) {
        $imageFilename = basename($img);

        //find the image extension
        $image_type = substr(strrchr($imageFilename,"."), 1);

        //give a new name, you can modify as per your requirement
        $filename = md5($img . strtotime('now')).'.'.$image_type;

        //path for temp storage folder: ./media/import/
        $filepath = Mage::getBaseDir('media') . DS . 'import'. DS . $filename;

        //store the image from external url to the temp storage folder
        $newImgUrl = file_put_contents($filepath, file_get_contents(trim($img)));

        return $filepath;
    }

    private function updateImages($productId, $images)
    {
        //Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID); // using admin store temporary
        $product = Mage::getModel('catalog/product')->load($productId);

        // create
        $product->setMediaGallery(array('images' => array(), 'values' => array()));
        
        // update
        $imagePath = Mage::getModel('catalog/product_media_config')->getMediaPath($product->getImage());
        $smallImagePath = Mage::getModel('catalog/product_media_config')->getMediaPath($product->getSmallImage());
        $thumbnailPath = Mage::getModel('catalog/product_media_config')->getMediaPath($product->getThumbnail());

        $currentProductImagesHashes = array(
            'image' => file_exists($imagePath) ? hash_file('sha1', $imagePath) : '',
            'small_image' => file_exists($smallImagePath) ? hash_file('sha1', $smallImagePath) : '',
            'thumbnail' => file_exists($thumbnailPath) ? hash_file('sha1', $thumbnailPath) : ''
        );

        if (!empty($images['image'])) {
            $image = $this->saveImageFromUrl($images['image']);
            if(file_exists($image)) {
                $imgHash = hash_file('sha1', $image);
                $imageExists = in_array($imgHash, $currentProductImagesHashes);

                if(!$imageExists) {
                    $product->addImageToMediaGallery($image, array('image'), true, false);
                }
            }
        }

        if (!empty($images['small_image'])) {
            $image = $this->saveImageFromUrl($images['small_image']);

            if(file_exists($image)) {
                $imgHash = hash_file('sha1', $image);
                $imageExists = in_array($imgHash, $currentProductImagesHashes);
                if(!$imageExists) {
                    $product->addImageToMediaGallery($image, array('small_image'), false, false);
                }
            }
        }

        if (!empty($images['thumbnail'])) {
            if(file_exists($image)) {
                $imgHash = hash_file('sha1', $image);
                $imageExists = in_array($imgHash, $currentProductImagesHashes);
                if(!$imageExists) {
                    $product->addImageToMediaGallery($image, array('thumbnail'), false, false);
                }
            }
        }


        if (isset($images['media_gallery']) && !empty($images['media_gallery'])) {
            $mediaGalleryImagesUrls = explode(';', $images['media_gallery']);
            foreach ($mediaGalleryImagesUrls as $value)
            {
                $image = $this->saveImageFromUrl($value);
                if(file_exists($image)) {
                    $product->addImageToMediaGallery($image, null, false, false);
//									}
                }
            }
        }


        $product->save();
    }

    public function createProductsAction()
    {
        $storeId = $this->getRequest()->getParam('target_id');
        $productData = $this->getRequest()->getParam('products');

        $api = new Mage_Catalog_Model_Product_Api();
//        Mage::app()->setCurrentStore($storeId);

        $appEmulation = Mage::getSingleton('core/app_emulation');
        $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($storeId);

        $errors = [];
        $newProductIds = [];
        $updatedProducts = [];

        foreach ($productData as $data) {
            $storeGeckoProductId = $data['product_id'];
            $magentoProductId = $data['external_product_id'];
            $productType = $data['type'];
            $attributeSetId = $data['attribute_set_id'];
            $productValues = $data['attributes'];
            $sku = $productValues['sku'];

            $productValues = CustomArrayHelpers::except($productValues, ['sku']);
            $productValues['website_ids'] = array(1);
            $productValues['tax_class_id'] = 2;
            $productValues['page_layout'] = 'two_columns_left';

            $productValues['category_ids'] = $data['categories'];

            $stockInventoryValues = $data['stock_inventory'];
            $images = $data['images'];

            try {
                if ($magentoProductId > 0) {
                    $productId = $magentoProductId;
                    $this->updateProduct($magentoProductId, $storeId, $productValues);
                    $updatedProducts[] = $storeGeckoProductId;
                } else {
                    $productId = $api->create(
                        strtolower($productType),
                        $attributeSetId,
                        $sku,
                        $productValues
                    );

                    $newProductIds[$storeGeckoProductId] = $productId;
                }

                $this->updateStockInventory($productId, $stockInventoryValues);
                $this->updateImages($productId, $images);

            } catch (Exception $ex) {
                $errors[] = [
                    'code' => $ex->getCode(),
                    'message' => $ex->getMessage(),
                    'file' => $ex->getFile(),
                    'line' => $ex->getLine(),
                    'trace' => $ex->getTrace()
                ];
            }

        }

        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);

        $this->getResponse()
            ->setHeader('Content-type', 'application/json')
            ->setBody(json_encode(array(
                'product_ids' => $newProductIds,
                'updated_products' => $updatedProducts,
                'errors' => $errors
            )));
    }

    public function productsImagesAction()
    {
        $filename = '/media/catalog/product/i/m/image_324.jpg';
        $dirFiles = scandir('/media/catalog/product/i/m');

        echo '<pre>' . print_r(getcwd(), $dirFiles, true) . '</pre>';

//        echo '<pre>' . print_r(array(file_exists($filename), $filename, 123,
//            $dirFiles), true) . '</pre>';
        exit;

        $image = file_get_contents($filename);
//        var_dump($image);

        $this->getResponse()
            ->setHeader('Content-type', 'image/jpeg')
            ->setBody($image);
    }

    public function productsCountAction()
    {
        $productsCount = Mage::getModel('catalog/product')
            ->getCollection()
            ->getSize();

        $this->getResponse()
            ->setHeader('Content-type', 'application/json')
            ->setBody(json_encode(array(
                'products_count' => $productsCount
            )));
    }

    private function getProductPage($pageId, $productsOnPage)
    {
        $productData = array();

        $stores = Mage::app()->getStores();
        $storeIds = array_map(function($store) {
            return $store->storeId;
        }, $stores);
        $storeIds[0] = Mage_Core_Model_App::ADMIN_STORE_ID;

        foreach ($storeIds as $storeId) {
            Mage::app()->setCurrentStore($storeId);

            $collection = Mage::getModel('catalog/product')
                ->getCollection()
                ->addAttributeToFilter('entity_type_id', 4)
                ->addAttributeToSelect('*')
                ->setPageSize($productsOnPage)
                ->setCurPage($pageId);

            foreach ($collection as $product) {
                $stockItem = Mage::getModel('cataloginventory/stock_item')
                    ->loadByProduct($product->getEntityId());

                $usedAttributes = null;
                $configurableAttributesData = null;
                $usedSimpleProducts = null;

                if ($product->getTypeId() === 'configurable') {
                    $usedAttributes = $product->getTypeInstance()
                        ->getUsedProductAttributeIds();

                    $configurableAttributesData = $product->getTypeInstance()
                        ->getConfigurableAttributesAsArray();


                    $usedSimpleProducts = Mage::getModel('catalog/product_type_configurable')
                        ->getChildrenIds($product->getId());
                }

                $productAttributeData = CustomArrayHelpers::except(
                    $product->getData(), array(
                        'website_ids',
                        'store_ids',
                        'category_ids',
                        'attribute_set_id',
                        'type_id',
                        'entity_type_id',
                        'entity_id',
                        'image',
                        'small_image',
                        'thumbnail'
                    )
                );

                if(!isset($productData[$product->getId()])) {
                    $productData[$product->getId()] = array(
                        'store_ids' => $product->getStoreIds(),
                        'website_ids' => $product->getStoreIds(),
                        'category_ids' => $product->getCategoryIds(),
                        'attribute_set_id' => $product->getAttributeSetId(),
                        'product_id' => $product->getEntityId(),
                        'type_id' => $product->getTypeId(),
                        'data' => [],
                        'stock' => $stockItem->getData(),
                        'relations' => array(
                            'cross_sell' => $product->getCrossSellLinkCollection()->toArray(),
                            'up_sell' => $product->getUpSellLinkCollection()->toArray(),
                            'related' => $product->getRelatedLinkCollection()->toArray(),
                            'associated' => array(
                                'simple_products' => $usedSimpleProducts,
                                'attributes' => $usedAttributes,
                                'attribute_data' => $configurableAttributesData
                            )
                        ),
                        'images' => array(
                            'base_image' => $product->getImageUrl(),
                            'small_image' => $product->getSmallImageUrl(),
                            'thumbnail_image' => $product->getThumbnailUrl(),
                            'media_gallery' => $product->getMediaGalleryImages()
                        )
                    );
                }

                $productData[$product->getId()]['data'][$storeId] = array_merge($productAttributeData, array(
                    'image' => $product->getImageUrl(),
                    'small_image' => $product->getSmallImageUrl(),
                    'thumbnail' => $product->getThumbnailUrl())
                );
            }
        }

        return $productData;
    }

    public function productsAction()
    {
        $pageId = $this->getRequest()->getParam('page_id');
        $productsOnPage = $this->getRequest()->getParam('products_on_page');

        $productData = $this->getProductPage($pageId, $productsOnPage);

        $this->getResponse()
            ->setHeader('Content-type', 'application/json')
            ->setBody(json_encode(
                $productData
            ));
    }
}

class CustomArrayHelpers
{
    public static function forget(&$array, $keys)
    {
        $original =& $array;
        foreach ((array)$keys as $key) {
            $parts = explode('.', $key);
            while (count($parts) > 1) {
                $part = array_shift($parts);
                if (isset($array[$part]) && is_array($array[$part])) {
                    $array =& $array[$part];
                }
            }
            unset($array[array_shift($parts)]);
            $array =& $original;
        }
    }

    public static function except($array, $keys)
    {
        static::forget($array, $keys);

        return $array;
    }
}


class LegacyMagentoDatabase
{
    private static $resource = null;
    private static $readConnection = null;
    private static $writeConnection = null;

    public static function ReadQuery($sql)
    {
        $result = false;
        if (self::init()) {
            $result = self::$readConnection->fetchAll($sql);
        }
        return $result;
    }

    public static function WriteQuery($sql)
    {
        $result = false;
        if (self::init()) {
            $result = self::$writeConnection->query($sql);
            $qInfo = array(
                'affected_rows' => $result->rowCount(),
                'insert_id' => self::$writeConnection->lastInsertId(),
            );
            $result = array('result' => ($result ? '1' : '0'), 'info' => $qInfo);
        }
        return $result;
    }

    protected static function init()
    {
        if (empty(self::$resource)) {
            self::$resource = Mage::getSingleton('core/resource');
            self::$readConnection = self::$resource->getConnection('core_read');
            self::$writeConnection = self::$resource->getConnection('core_write');
        }
        return (!empty(self::$resource));
    }
}

class LegacyHelperFunctions
{
    public static function getDBTablePrefix()
    {
        $prefix = Mage::getConfig()->getTablePrefix();
        return $prefix;
    }
}