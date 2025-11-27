<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$UID = (("".$_GET["uid"] == "")?"":("".intval("".$_GET["uid"])));
?>
<div class="like_widget wishlist_container"><a id="wishlist" href="<?=$arParams['PATH_TO_WISHLIST']?><?if($UID != ""){ echo "?uid=".$UID; }?>" title="Избранное"><i class="mso mi mi_favorite"><span id="qty" class="qty"><?=$arResult['ELEMENTS_COUNT']?></span></i></a></div>