<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateProductVariationStockView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $condition = $this->conditionByDbConnection();

        DB::statement("CREATE OR REPLACE VIEW product_variation_stock_view AS
            SELECT
                product_variations.product_id AS product_id,
                product_variations.id AS product_variation_id,
                (
                    COALESCE(SUM(stocks.quantity), 0) - COALESCE(SUM(product_variation_order.quantity), 0)
                ) AS stock,
                {$condition} as in_stock
            FROM
                product_variations
            LEFT JOIN (
                SELECT
                    stocks.product_variation_id AS id,
                    COALESCE(SUM(stocks.quantity), 0) AS quantity
                FROM
                    stocks
                GROUP BY
                    stocks.product_variation_id
            ) AS stocks USING(id)
            LEFT JOIN (
                SELECT
                    product_variation_order.product_variation_id AS id,
                    COALESCE(SUM(product_variation_order.quantity), 0) AS quantity
                FROM
                    product_variation_order
                GROUP BY
                    product_variation_order.product_variation_id
            ) AS product_variation_order USING(id)
            GROUP BY
                product_variations.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS `product_variation_stock_view`");
    }

    /**
     * Condition By Db Connection
     *
     * @return string
     */
    public function conditionByDbConnection(): string
    {
        if (env('DB_CONNECTION') == 'pgsql') {
            return $this->conditionForPsql();
        }

        if (env('DB_CONNECTION') == 'mysql') {
            return $this->conditionForMysql();
        }
    }

    /**
     * Condition For Mysql.
     *
     * @return string
     */
    public function conditionForMysql(): string
    {
        return "IF(COALESCE(SUM(stocks.quantity), 0) - COALESCE(SUM(product_variation_order.quantity), 0) > 0, true, false)";
    }

    /**
     * Condition For Psql.
     *
     * @return string
     */
    public function conditionForPsql(): string
    {
        return "
        (CASE WHEN COALESCE(SUM(stocks.quantity), 0) - COALESCE(SUM(product_variation_order.quantity), 0) > 0
            THEN true
            ELSE false
        END)
        ";
    }
}
