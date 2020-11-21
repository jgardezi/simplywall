<?php


class CompanyApiTest extends TestCase
{
    /**
     * General company API endpoint test response.
     */
    public function testCompanyApi()
    {
        $this->call('GET', '/companies');

        $this->assertResponseStatus(200);
        $this->seeJson();
        $this->seeJsonStructure([
            'data' => ['*' => [
                'id',
                'name',
                'uniqueSymbol',
                'exchangeSymbol',
                'lastKnowSharePrice',
                'snowFlakeScoreTotal',
            ]],
            'meta' => [
                'last_page',
                'to',
                'total',
                'per_page',
                'current_page',
                'links',
            ],
        ]);
    }

    /**
     * Company API endpoint Pagination.
     */
    public function testCompanyApiPagination()
    {
        $params = [
            'page' => 2,
            'limit' => 10,
        ];
        $this->call('GET', '/companies', $params);

        $this->seeStatusCode(200);
        $this->seeJsonContains([
            "from"         => 11,
            "current_page" => 2,
            "per_page"     => 10,
        ]);
    }

    /**
     * Company API endpoint filter params test response.
     */
    public function testCompanyApiFilterParams()
    {
        $params = [
            'scoreTotal' => 13,
            'exchangeSymbols' => 'NYSE',
        ];
        $this->call('GET', '/companies', $params);

        $this->assertResponseStatus(200);
        $this->seeJsonContains([
            "exchangeSymbol"      => "NYSE",
            "snowFlakeScoreTotal" => 13,
        ]);
        $this->seeJsonDoesntContains(["snowFlakeScoreTotal" => 20]);
        $this->seeJsonDoesntContains(["snowFlakeScoreTotal" => 9]);
        $this->seeJsonDoesntContains(["snowFlakeScoreTotal" => 12]);
        $this->seeJsonDoesntContains(["snowFlakeScoreTotal" => 18]);
    }
}

