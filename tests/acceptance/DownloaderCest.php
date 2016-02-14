<?php

include_once "Dragon.php";

class DownloaderCest
{
	private $dragonInfo = [];

    public function _before(AcceptanceTester $I)
    {
	    $this->dragonInfo = json_decode(file_get_contents('dragon_info.json'), true);
    }

    public function _after(AcceptanceTester $I)
    {
	    file_put_contents('dragon_info.json', json_encode($this->dragonInfo, JSON_PRETTY_PRINT));
    }

	public function _failed(AcceptanceTester $I)
	{
		file_put_contents('dragon_info.json', json_encode($this->dragonInfo, JSON_PRETTY_PRINT));
	}

    // tests
    public function grabDragonInfo(AcceptanceTester $I)
    {
	    $dragons = json_decode(file_get_contents('dragons.json'));
	    foreach ($dragons as $dragonName) {
		    if (in_array($dragonName, array_keys($this->dragonInfo))) {
			    continue;
		    }

		    $I->wantTo("Read data of dragon $dragonName");
			$I->amOnPage("/wiki/$dragonName");
		    $I->waitForElementVisible("#WikiaPageHeader > div > div.header-column.header-title");
		    $isClassicDragon = true;
		    try {
			    $I->seeElement("#mw-content-text > table.infobox.Template > tbody");
		    } catch(\Exception $e) {
				$isClassicDragon = false;
		    }
		    if ($isClassicDragon) {
			    $dragon = new Dragon();
			    $dragon->name = $dragonName;
			    $dragon->fishPerHour = $I->grabTextFrom("//*[@id=\"mw-content-text\"]/table[1]/tbody/tr[td//text()[contains(., 'Fish.png')]]/td[2]");
			    $dragon->woodPerHour = $I->grabTextFrom("//*[@id=\"mw-content-text\"]/table[1]/tbody/tr[td//text()[contains(., 'Wood.png')]]/td[2]");
			    $dragon->collectTime = $I->grabTextFrom("//*[@id=\"mw-content-text\"]/table[1]/tbody/tr[td//text()[contains(., 'Time.png')]]/td[2]");
			    $dragon->iron = $I->grabTextFrom("//*[@id=\"mw-content-text\"]/table[1]/tbody/tr[td//text()[contains(., 'Iron-Icon.png')]]/td[2]");
			    if ($dragon->iron != "Cannot Collect") {
				    $dragon->ironTime = $I->grabTextFrom("//*[@id=\"mw-content-text\"]/table[1]/tbody/tr[td//text()[contains(., 'Time.png')]][2]/td[2]");
			    } else {
				    $dragon->ironTime = "Cannot Collect";
			    }
			    try {
				    $dragon->battleType = $I->grabTextFrom("//*[@id=\"mw-content-text\"]/table[1]/tbody/tr[td//text()[contains(., 'Range_Icon.png')]]/td[2]");
			    } catch(\Exception $e) {
				    $dragon->battleType = "TODO: add";
			    }
			    $this->dragonInfo[$dragonName] = $dragon;
		    } else {
			    $this->dragonInfo[$dragonName] = "Not classic dragon.";
		    }
		}

    }
}
