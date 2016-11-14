<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Рейтинг");
?>
    <div class="tabo">
        <div class="tabs-wrap">
            <!-- active tab on page load gets checked attribute-->
            <input id="tab1" type="radio" name="tabGroup1" checked="" class="tabs">
            <label for="tab1">Участники</label>
            <input id="tab2" type="radio" name="tabGroup1" class="tabs">
            <label for="tab2">Города</label>
            <div class="tabs__content js-ajax-container" id="rating-participants">
                <?
				$arrFilter = array('ACTIVE' => 'Y');
                $APPLICATION->IncludeComponent(
					"site:users.list",
					"rating-page",
					array(
						"FIELDS" => array(
							0 => "NAME",
							1 => "LAST_NAME",
							2 => "PERSONAL_PHOTO",
							3 => "PERSONAL_CITY",
							4 => "PERSONAL_COUNTRY",
							5 => "",
						),
						"UFIELDS" => array(
							0 => "UF_*",
						),
						"SHOW_PAGER" => "Y",
						"PAGE_ELEMENT_COUNT" => "10",
						"SORT_BY" => array("UF_PROGRAM" => "desc", "UF_RATING" => "desc", "ID" => 'asc'),
						"PAGER_TEMPLATE" => "arrows-rating",
						"COMPONENT_TEMPLATE" => "rating-page",
						"AJAX_ID" => "",
						"LINE_ELEMENT_COUNT" => "5",
						"USERS_COUNT" => "999",
						"FILTER_NAME" => "arrFilter",
						"LIST_TITLE" => "",
						"ADD_ELEMENT_CHAIN" => "N",
						"LIST_LINK_DETAIL" => "N",
						"LIST_SHOW_PHOTO" => "Y",
						"LIST_SHOW_FILTER" => "Y",
						"SEF_MODE" => "N",
						"CACHE_TYPE" => "A",
						"CACHE_TIME" => "0",
						"SET_TITLE" => "Y"
					),
					false
				);
                ?>
            </div>
            <div class="tabs__content js-ajax-container" id="rating-cities">
                <?
                global $arrFilterCities;
                $arrFilterCities = array('!NAME' => false, 'ACTIVE' => 'Y');
                $APPLICATION->IncludeComponent(
	"site:users.list.group", 
	"rating-page", 
	array(
		"FIELDS" => array(
			0 => "PERSONAL_CITY",
			1 => "PERSONAL_COUNTRY",
			2 => "",
		),
		"GROUP_BY" => "PERSONAL_CITY",
		"SHOW_PAGER" => "Y",
		"PAGE_ELEMENT_COUNT" => "10",
		"SORT_BY" => "CNT",
		"SORT_ORDER" => "DESC",
		"PAGER_TEMPLATE" => "arrows-rating",
		"COMPONENT_TEMPLATE" => "rating-page",
		"AJAX_ID" => "",
		"LINE_ELEMENT_COUNT" => "5",
		"USERS_COUNT" => "999",
		"FILTER_NAME" => "arrFilterCities",
		"LIST_TITLE" => "",
		"ADD_ELEMENT_CHAIN" => "N",
		"LIST_LINK_DETAIL" => "N",
		"LIST_SHOW_PHOTO" => "Y",
		"LIST_SHOW_FILTER" => "Y",
		"SEF_MODE" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"SET_TITLE" => "Y"
	),
	false
);
                ?>
            </div>
        </div>
    </div>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>