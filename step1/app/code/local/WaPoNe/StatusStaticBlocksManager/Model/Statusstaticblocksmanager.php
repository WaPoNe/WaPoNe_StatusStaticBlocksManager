<?php

class WaPoNe_StatusStaticBlocksManager_Model_StatusStaticBlocksManager extends Mage_Core_Model_Abstract
{

    const ACTIVE = 1;
    const DEACTIVE = 0;

    protected function _construct()
    {
        $this->_init('statusstaticblocksmanager/statusstaticblocksmanager');
    }

    /* WaPoNe (12-08-2016): Blocks enabling */
    private function enableBlocks()
    {
        // Check dates
        if ($this->getActionDate('statusstaticblocksmanager/statusstaticblocksmanager_group/enablestartdate', 'statusstaticblocksmanager/statusstaticblocksmanager_group/enablestarttime')) {

            //Mage::log('Enabling blocks', null, 'wapone.log');

            //Blocks list to enable
            $blocks_to_enable = $this->getBlocks('statusstaticblocksmanager/statusstaticblocksmanager_group/blockstoenable');

            if (count($blocks_to_enable) > 0) {
                for ($row = 0; $row < count($blocks_to_enable); $row++) {
                    //Mage::log('Block to enable:'.$blocks_to_enable[$row], null, 'wapone.log');
                    Mage::getModel('cms/block')->load($blocks_to_enable[$row])
                        ->setData('is_active', self::ACTIVE)
                        ->save();
                }
                /*** If you are using Letsi FPC module uncomment line below ***/
                //Mage::getSingleton('fpc/fpc')->clean();
                /*** In any case, you have to flush the cache, if you're using one ***/

                Mage::getConfig()->saveConfig('statusstaticblocksmanager/statusstaticblocksmanager_group/module_enabling_status', '0', 'default', 0);
            }
        }
    }

    /* WaPoNe (12-08-2016): Blocks disabling */
    private function disableBlocks()
    {
        // Check dates
        if ($this->getActionDate('statusstaticblocksmanager/statusstaticblocksmanager_group/disablestartdate', 'statusstaticblocksmanager/statusstaticblocksmanager_group/disablestarttime')) {

            Mage::log('Deactive blocks', null, 'wapone.log');

            //Blocks list to deactive
            $blocks_to_disable = $this->getBlocks('statusstaticblocksmanager/statusstaticblocksmanager_group/blockstodisable');

            if (count($blocks_to_disable) > 0) {
                for ($row = 0; $row < count($blocks_to_disable); $row++) {
                    Mage::log('Block da disattivare:'.$blocks_to_disable[$row], null, 'wapone.log');
                    Mage::getModel('cms/block')->load($blocks_to_disable[$row])
                        ->setData('is_active', self::DEACTIVE)
                        ->save();
                }
                /*** If you are using Letsi FPC module uncomment line below ***/
                //Mage::getSingleton('fpc/fpc')->clean();
                /*** In any case, you have to flush the cache, if you're using one ***/

                Mage::getConfig()->saveConfig('statusstaticblocksmanager/statusstaticblocksmanager_group/module_disabling_status', '0', 'default', 0);
            }
        }
    }

    public function manageBlocksStatus()
    {
        if ((int)Mage::getStoreConfig('statusstaticblocksmanager/statusstaticblocksmanager_group/module_enabling_status') === 1) :
            $this->enableBlocks();
        endif;

        if ((int)Mage::getStoreConfig('statusstaticblocksmanager/statusstaticblocksmanager_group/module_disabling_status') === 1) :
            $this->disableBlocks();
        endif;
    }

    /* WaPoNe (16-08-2016): to check if it's time to start script */
    private function getActionDate($date_param, $time_param)
    {
        $date = Mage::getStoreConfig($date_param);
        $time = Mage::getStoreConfig($time_param);

        if (!empty($date)) {
            $now = Mage::app()->getLocale()->date()->toString('yy-MM-dd HH.mm');
            $date1 = new DateTime($now);

            $arr_date = explode("-", $date);
            $arr_time = explode(",", $time);

            try {
                $date2 = new DateTime($arr_date[2] . "-" . $arr_date[1] . "-" . $arr_date[0] . " " . $arr_time[0] . ":" . $arr_time[1] . ":" . $arr_time[2]);
            } catch (Exception $e) {
                Mage::log($e->getMessage(), null, 'wapone.log');
            }
            // Mage::log("Date1:".$date1->format('Y-m-d H:i:s')." - Date2:".$date2->format('Y-m-d H:i:s'), null, "wapone.log");

            if ($date1 >= $date2) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    /* WaPoNe (16-08-2016): Obtaining blocks list to enable/disable */
    public function getBlocks($param)
    {
        $blocks = Mage::getStoreConfig($param);
        $arr_result = array();

        if (!empty($blocks)):
            $arr_result = explode("|", $blocks);
        endif;

        return $arr_result;
    }

}
