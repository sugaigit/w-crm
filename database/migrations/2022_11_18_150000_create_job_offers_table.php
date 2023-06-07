<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->comment('営業担当');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('handling_type')->comment('取扱会社種別（1:HA, 2:HC）');
            $table->string('job_number', 100)->nullable()->comment('仕事番号');
            $table->string('handling_office')->comment('取扱事業所名（1:北九州本社, 2:福岡支店）');
            $table->string('business_type')->comment('事業種別（1:民間事業, 2:行政事業）');
            $table->bigInteger('customer_id')->unsigned()->nullable()->comment('顧客');
            $table->foreign('customer_id')->nullable()->references('id')->on('customers');
            $table->string('type_contract')->comment('契約形態（1:一般派遣, 2:紹介予定派遣, 3:人材紹介, 4:請負, 5:採用代行）');
            $table->integer('recruitment_number')->comment('募集人数');//
            $table->string('company_name', 100)->comment('就業先名称');//
            $table->string('company_address', 100)->comment('就業先住所');//
            $table->string('company_others', 100)->nullable()->comment('就業先備考');//
            $table->string('ordering_business', 100)->comment('発注業務');//
            $table->string('order_details', 100)->comment('発注業務詳細');//
            //新規追加
            $table->string('number_of_ordering_bases')->comment('発注拠点数(1:単独拠点, 2:複数拠点（P&C拠点内）, 3:全拠点（P&C拠点内）' )->nullable();//
            $table->string('order_number')->comment('発注人数（1:地域限定, 2:複数地域, 3:全国展開）')->nullable();//
            $table->string('transaction_duration')->comment('取引継続期間（1:無し, 2:低い, 3:高い）')->nullable();//
            $table->string('expected_sales')->comment('売上見込み額（1:創業10年未満, 2:創業10年以上, 3:創業30年以上）')->nullable();//
            $table->string('profit_rate')->comment('利益率（1:14%以下, 2:15%〜20%, 3:21%以上)')->nullable();//
            $table->string('special_matters')->comment('特別事項（（1:配慮不要,2:マネージャー決裁,3:役員決裁）')->nullable();//
            //ここまで
            $table->string('counter_measures')->comment('喫煙対策内容');//
            $table->string('invoice_unit_price_1', 100)->comment('請求単価①');//
            $table->string('billing_unit_1', 100)->comment('請求単位①');//
            $table->string('profit_rate_1', 100)->comment('利益率①');//
            $table->string('billing_information_1', 100)->comment('請求情報①備考')->nullable();//
            $table->string('invoice_unit_price_2', 100)->comment('請求単価②')->nullable();//
            $table->string('billing_unit_2', 100)->comment('請求単位②')->nullable();//
            $table->string('profit_rate_2', 100)->comment('利益率②')->nullable();//
            $table->string('billing_information_2', 100)->comment('請求情報②備考')->nullable();//
            $table->string('invoice_unit_price_3', 100)->comment('請求単価③')->nullable();//
            $table->string('billing_unit_3', 100)->comment('請求単位③')->nullable();//
            $table->string('profit_rate_3', 100)->comment('利益率③')->nullable();//
            $table->string('billing_information_3', 100)->comment('請求情報③備考')->nullable();//
            $table->string('employment_insurance', 100)->comment('雇用保険加入');//
            $table->string('social_insurance', 100)->comment('社会保険加入');//
            $table->string('payment_unit_price_1', 100)->comment('支払単価①');//
            $table->string('payment_unit_1', 100)->comment('支払単位①');//
            $table->string('carfare_1', 100)->comment('交通費①');//
            $table->string('carfare_payment_1', 100)->comment('交通費支払単位①');//
            $table->string('carfare_payment_remarks_1', 100)->comment('支払情報①備考')->nullable();//
            $table->string('employment_insurance_2', 100)->comment('雇用保険加入②');//
            $table->string('social_insurance_2', 100)->comment('社会保険加入②');//
            $table->string('payment_unit_price_2', 100)->comment('支払単価②')->nullable();//
            $table->string('payment_unit_2', 100)->comment('支払単位②')->nullable();//
            $table->string('carfare_2', 100)->comment('交通費②')->nullable();//
            $table->string('carfare_payment_2', 100)->comment('交通費支払単位②')->nullable();//
            $table->string('carfare_payment_remarks_2', 100)->comment('支払情報②備考')->nullable();//
            $table->string('employment_insurance_3', 100)->comment('雇用保険加入③');//
            $table->string('social_insurance_3', 100)->comment('社会保険加入③');//
            $table->string('payment_unit_price_3', 100)->comment('支払単価③')->nullable();//
            $table->string('payment_unit_3', 100)->comment('支払単位③')->nullable();//
            $table->string('carfare_3', 100)->comment('交通費③')->nullable();//
            $table->string('carfare_payment_3', 100)->comment('交通費支払単位③')->nullable();//
            $table->string('carfare_payment_remarks_3', 100)->comment('支払情報③備考')->nullable();//
            $table->string('scheduled_period')->comment('予定期間')->nullable();//
            $table->date('expected_end_date')->comment('終了予定日')->nullable();//
            $table->text('period_remarks')->comment('期間備考')->nullable();//
            $table->string('holiday')->comment('休日');//
            $table->string('long_vacation')->comment('長期休暇');//
            $table->text('holiday_remarks')->comment('休日備考')->nullable();//
            $table->string('working_hours_1')->comment('勤務時間①');//
            $table->string('actual_working_hours_1')->comment('実働時間①');//
            $table->string('break_time_1')->comment('休憩時間①');//
            $table->string('overtime')->comment('残業(時間/月)');//
            $table->text('working_hours_remarks')->comment('勤務時間備考')->nullable();//
            $table->string('working_hours_2')->comment('勤務時間②')->nullable();//
            $table->string('actual_working_hours_2')->comment('実働時間②')->nullable();//
            $table->string('break_time_2')->comment('休憩時間②')->nullable();//
            $table->string('working_hours_3')->comment('勤務時間③')->nullable();//
            $table->string('actual_working_hours_3')->comment('実働時間③')->nullable();//
            $table->string('break_time_3')->comment('休憩時間③')->nullable();//
            $table->string('nearest_station')->comment('最寄り駅')->nullable();//
            $table->string('travel_time_station')->comment('駅からの所要時間')->nullable();//
            $table->string('nearest_bus_stop')->comment('最寄りバス停')->nullable();
            $table->string('travel_time_bus_stop')->comment('バス停からの所要時間')->nullable();
            $table->string('commuting_by_car')->comment('車通勤（可能）');
            $table->text('traffic_commuting_remarks')->comment('交通通勤備考')->nullable();
            $table->string('parking')->comment('駐車場');
            $table->string('posting_site')->comment('求人掲載サイト')->nullable();
            $table->string('status')->comment('作成ステータス');
            $table->date('order_date')->comment('起算日');
            $table->string('after_introduction')->comment('紹介後')->nullable();
            $table->string('timing_of_switching')->comment('直接雇用切替時期')->nullable();
            $table->string('monthly_lower_limit')->comment('月収例（下限）')->nullable();
            $table->string('monthly_upper_limit')->comment('月収例（上限）')->nullable();
            $table->string('annual_lower_limit')->comment('年収例（下限）')->nullable();
            $table->string('annual_upper_limit')->comment('年収例（上限）')->nullable();
            $table->string('bonuses_treatment')->comment('賞与等・待遇')->nullable();
            $table->string('holidays_vacations')->comment('休日・休暇')->nullable();
            $table->text('introduction_others')->comment('その他')->nullable();
            $table->string('qualification', 10)->comment('資格要件（0:不問、1:歓迎、2:必須）')->nullable();
            $table->string('qualification_content', 100)->comment('資格名')->nullable();
            $table->string('experience', 10)->comment('経験要件（0:不問、1:歓迎、2:必須）')->nullable();
            $table->string('experience_content', 10)->comment('経験内容')->nullable();
            $table->string('sex', 10)->comment('性別要件（0:不問、1:歓迎、2:必須）')->nullable();
            $table->string('age', 100)->comment('年齢要件')->nullable();
            $table->string('uniform_supply', 10)->comment('制服支給の有無（0:なし, 1:あり（自己負担あり), あり（自己負担なし））')->nullable();
            $table->string('supply', 100)->comment('支給物')->nullable();
            $table->string('clothes', 100)->comment('服装')->nullable();
            $table->string('other_hair_colors', 100)->comment('その他・髪色')->nullable();
            $table->string('self_prepared', 100)->comment('自身で準備するもの')->nullable();
            $table->text('remarks_workplace')->comment('職場の雰囲気・備考')->nullable();
            $table->string('gender_ratio')->comment('男女比')->nullable();
            $table->string('age_ratio')->comment('年齢比率')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_offers');
    }
}
