<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

$cp = $this->__component; // объект компонента

if (is_object($cp)) {
    $cp->SetResultCacheKeys(array('UF_H1','UF_SUBTITLE'));
}

