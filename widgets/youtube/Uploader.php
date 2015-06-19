<?php
/**
 * @link https://github.com/ingus-indigo/yii2-omni-googleapis
 * @copyright Copyright (c) 2015 ingus-inigo
 * @license MIT License (http://opensource.org/licenses/MIT)
 */

namespace omni\googleApis\widgets\youtube;

use yii;
use yii\helpers\Html;

class Uploader extends \yii\widgets\InputWidget
{
    const TYPE_INPUT = 1;

    public $form;
    public $type = self::TYPE_INPUT;

    /**
     * @var array the HTML attributes for the input tag.
     */
    public $options = [];

    public function init()
    {
        parent::init();
        if (isset($this->form) && !($this->form instanceof \yii\widgets\ActiveForm)) {
            throw new InvalidConfigException("The 'form' property must be of type \\yii\\widgets\\ActiveForm");
        }
        if (isset($this->form) && !$this->hasModel()) {
            throw new InvalidConfigException("You must set the 'model' and 'attribute' properties when the 'form' property is set.");
        }
        $this->registerAssets();
        echo $this->renderInput();
    }

    /**
     * Renders the source input for the youtube uploader widget.
     * Graceful fallback to a normal HTML  text input
     */
    protected function renderInput()
    {
        Html::addCssClass($this->options, 'form-control');

        if ($this->hasModel()) {
            return Html::activeFileInput($this->model, $this->attribute, $this->options);
        }
    }

    /**
     * Registers the widget assets uploadifive.
     */
    public function registerAssets()
    {
        $view = $this->getView();
        $id = "jQuery('#" . $this->options['id'] . "')";

       /* if ($this->type == self::TYPE_INLINE) {
            $this->pluginEvents = ArrayHelper::merge($this->pluginEvents, ['changeDate' => 'function (e) { ' . $id . '.val(e.format());} ']);
        }*/
        if ($this->type === self::TYPE_INPUT) {
            \omni\googleApis\assets\UploadiFiveAsset::register($view);
        }
    }

}
?>
