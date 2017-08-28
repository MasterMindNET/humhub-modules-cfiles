<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\cfiles\controllers;

use Yii;
use yii\web\HttpException;
use humhub\modules\cfiles\models\FileSystemItem;

/**
 * Description of BrowseController
 *
 * @author luke, Sebastian Stumpf
 */
class DeleteController extends BrowseController
{

    /**
     * Action to delete a file or folder.
     * @return string
     */
    public function actionIndex()
    {
        if (!$this->canWrite()) {
            throw new HttpException(401, Yii::t('CfilesModule.base', 'Insufficient rights to execute this action.'));
        }
        
        $selectedItems = Yii::$app->request->post('selection');
        
        if (is_array($selectedItems)) {
            foreach ($selectedItems as $itemId) {
                $item = FileSystemItem::getItemById($itemId);
                if ($item && $item->isDeletable()) {
                    $item->delete();
                }
            }
        }

        return $this->renderFileList();
    }
}
