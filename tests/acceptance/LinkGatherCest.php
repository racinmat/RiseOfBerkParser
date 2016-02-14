<?php


class LinkGatherCest
{

	private $dragons = [];

    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }

	public function _failed(AcceptanceTester $I)
	{
		file_put_contents('dragons.json', json_encode($this->dragons, JSON_PRETTY_PRINT));
	}

    // tests
    public function _grabLinks(AcceptanceTester $I) //smazat podtržítko pro zapnutí testu
    {
	    $dragonsListUrl = "/wiki/Category:Dragons";
	    $I->amOnPage($dragonsListUrl);
	    $pages = 14;
	    for ($i = 1; $i <= $pages; $i++) {
		    $link = "/wiki/Category:Dragons?page=$i";
		    $I->amOnPage($link);
		    $this->_grabLinksFromOnePage($I);
	    }
	    file_put_contents('dragons.json', json_encode($this->dragons, JSON_PRETTY_PRINT));
    }

	public function _grabLinksFromOnePage(AcceptanceTester $I)
	{
		$ok = true;
		$i = 1;
		while($ok) {
			try {
				$selector = "#mw-pages > div.category-gallery > div > div.category-gallery-room1 > div:nth-child($i) > a";
				$text = $I->grabTextFrom($selector);
				$this->dragons[] = $text;
				$i++;
			} catch(\Exception $e) {
				$ok = false;
			}
		}
	}
}
