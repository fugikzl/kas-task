<?php
namespace App\Parsers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\StorePoint;
use App\Models\StoreProduct;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class KaspiParser
{
    public string $category;
    public string $categoryRawName;
    public int $pages = 5;

    public function __construct(string $category, int $pages = 5, $categoryRawName)
    {
        $this->category = $category;
        $this->pages = $pages;
        $this->categoryRawName = $categoryRawName;
    }

    public function parse()
    {
        $categoryId = Category::firstOrCreate(["name" => $this->categoryRawName])->id;
        $pages = $this->pages;
        $client = new Client();
        $category = $this->category;

        for($p = 1; $p <=$pages; $p++)
        {
            $url = "https://kaspi.kz/yml/product-view/pl/filters?q=:category:".$category."&text&all&ui=d&i=-1&page=".$p;
           
            $response = $client->request("GET",$url,[
                "headers" => [
                    'Accept' => 'application/json',
                    'Referer' => 'https://kaspi.kz/shop/c/'.$category,
                ]
            ]);
            $cards = json_decode($response->getBody(),true)["data"]["cards"];

            foreach($cards as $card)
            {
                $cardId = $card["id"];
                $cardInfo = $client->request("POST", "https://kaspi.kz/yml/offer-view/offers/".$cardId,[
                    "headers" => [
                        'Accept' => 'application/json, text/*',
                        'Accept-Encoding' => 'gzip, deflate, br',
                        'Referer' => 'https://kaspi.kz/shop/p/'
                    ],
                    'json' => [
                        "cityId" =>"710000000",
                        "id" => $cardId,
                        "merchantUID" => "",
                        "limit" => 5,
                        "sort" => true]
                ]);

                $product = Product::updateOrCreate(
                    [
                        "name" => $card["title"],
                    ],
                    [
                        "name" => $card["title"],
                        "image" => $card["previewImages"][0]["medium"],
                        "categoryId" => $categoryId,
                        
                    ]
                );

                $offers = json_decode($cardInfo->getBody(),true)["offers"];
                // dd($offers);
                foreach($offers as $offer)
                {
                    $name = $offer["merchantName"];
                    $merchantId = $offer["merchantId"];

                    $addressUrl = "https://kaspi.kz/shop/info/merchant/".$merchantId."/address-tab/?merchantId=".$merchantId;
                    $html = $client->request("GET",$addressUrl)->getBody()->getContents();
                    $crawler = new Crawler($html);

                    $addressCrawler = $crawler->filter(".merchant-address__list-content-item._address");
                    $addresses = [];
                    try {

                        $addresses = $addressCrawler->each(function($e){
                            return $e->text();
                        });
                
                        
                    } catch (\Throwable $th) {
                        
                    }

                    if(array_key_exists(1,$addresses))
                    {
                        $store = Store::firstOrCreate(["name" => $name]);
                        
                        StoreProduct::updateOrCreate(
                            [
                                "storeId" => $store->id,
                                "productId" => $product->id
                            ],
                            [
                                "storeId" => $store->id,
                                "productId" => $product->id,
                                "price" => $offer["price"],
                            ]
                        );

                        foreach($addresses as $address)
                        {
                            
                            $addressResponse = $client->request("GET","https://geocode.arcgis.com/arcgis/rest/services/World/GeocodeServer/findAddressCandidates",[
                                'query' => [
                                    'singleLine' => $address,
                                    'preferredLabelValues' => "matchedCity",
                                    "outFields" => "Match_addr,City",
                                    "maxLocations" => 1,
                                    "forStorage" => false,
                                    "f" => "json"
                                 ]
                            ]);
                            
                            $candidates = json_decode($addressResponse->getBody(),true)["candidates"];

                            StorePoint::updateOrCreate(
                                [
                                    "address" => $address,
                                    "storeId" => $store->id,
                                ],
                                [
                                    "address" => $address,
                                    "storeId" => $store->id,
                                    "lng" => array_key_exists(0,$candidates) ? $candidates[0]["location"]["x"] : null,
                                    "lat" => array_key_exists(0,$candidates) ? $candidates[0]["location"]["y"] : null,
                                ]
                            );
                        }
                    }

                }
            }
        }

    }
}

?>