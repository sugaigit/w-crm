<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftJobOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_job_offers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->comment('営業担当')->nullable();
            $table->string('handling_type')->nullable()->comment('取扱会社種別（1:HA, 2:HC）');
            $table->string('job_number', 100)->nullable()->comment('仕事番号');
            $table->string('handling_office')->nullable()->comment('取扱事業所名（1:北九州本社, 2:福岡支店）');
            $table->string('business_type')->nullable()->comment('事業種別（1:民間事業, 2:行政事業）');
            $table->bigInteger('customer_id')->nullable()->unsigned()->nullable()->comment('顧客');
            $table->string('type_contract')->nullable()->comment('契約形態（1:一般派遣, 2:紹介予定派遣, 3:人材紹介, 4:請負, 5:採用代行）');
            $table->integer('recruitment_number')->nullable()->comment('募集人数');//
            $table->string('company_name', 100)->nullable()->comment('就業先名称');//
            $table->string('company_address', 100)->nullable()->comment('就業先住所');//
            $table->string('company_others', 100)->nullable()->comment('就業先備考');//
            $table->string('ordering_business', 100)->nullable()->comment('発注業務');//
            $table->string('order_details', 100)->nullable()->comment('発注業務詳細');//
            $table->string('counter_measures')->comment('喫煙対策内容')->nullable();//
            $table->string('invoice_unit_price_1', 100)->comment('請求単価①')->nullable();//
            $table->string('billing_unit_1', 100)->comment('請求単位①')->nullable();//
            $table->string('profit_rate_1', 100)->comment('利益率①')->nullable();//
            $table->string('billing_information_1', 100)->comment('請求情報①備考')->nullable();//
            $table->string('invoice_unit_price_2', 100)->comment('請求単価②')->nullable();//
            $table->string('billing_unit_2', 100)->comment('請求単位②')->nullable();//
            $table->string('profit_rate_2', 100)->comment('利益率②')->nullable();//
            $table->string('billing_information_2', 100)->comment('請求情報②備考')->nullable();//
            $table->string('invoice_unit_price_3', 100)->comment('請求単価③')->nullable();//
            $table->string('billing_unit_3', 100)->comment('請求単位③')->nullable();//
            $table->string('profit_rate_3', 100)->comment('利益率③')->nullable();//
            $table->string('billing_information_3', 100)->comment('請求情報③備考')->nullable();//
            $table->string('employment_insurance', 100)->comment('雇用保険加入')->nullable();//
            $table->string('social_insurance', 100)->comment('社会保険加入')->nullable();//
            $table->string('payment_unit_price_1', 100)->comment('支払単価①')->nullable();//
            $table->string('payment_unit_1', 100)->comment('支払単位①')->nullable();//
            $table->string('carfare_1', 100)->comment('交通費①')->nullable();//
            $table->string('carfare_payment_1', 100)->comment('交通費支払単位①')->nullable();//
            $table->string('carfare_payment_remarks_1', 100)->comment('支払情報①備考')->nullable();//
            $table->string('employment_insurance_2', 100)->comment('雇用保険加入②')->nullable();//
            $table->string('social_insurance_2', 100)->comment('社会保険加入②')->nullable();//
            $table->string('payment_unit_price_2', 100)->comment('支払単価②')->nullable();//
            $table->string('payment_unit_2', 100)->comment('支払単位②')->nullable();//
            $table->string('carfare_2', 100)->comment('交通費②')->nullable();//
            $table->string('carfare_payment_2', 100)->comment('交通費支払単位②')->nullable();//
            $table->string('carfare_payment_remarks_2', 100)->comment('支払情報②備考')->nullable();//
            $table->string('employment_insurance_3', 100)->comment('雇用保険加入③')->nullable();//
            $table->string('social_insurance_3', 100)->comment('社会保険加入③')->nullable();//
            $table->string('payment_unit_price_3', 100)->comment('支払単価③')->nullable();//
            $table->string('payment_unit_3', 100)->comment('支払単位③')->nullable();//
            $table->string('carfare_3', 100)->comment('交通費③')->nullable();//
            $table->string('carfare_payment_3', 100)->comment('交通費支払単位③')->nullable();//
            $table->string('carfare_payment_remarks_3', 100)->comment('支払情報③備考')->nullable();//
            $table->string('scheduled_period')->comment('予定期間')->nullable();//
            $table->date('expected_end_date')->comment('終了予定日')->nullable();//
            $table->text('period_remarks')->comment('期間備考')->nullable();//
            $table->string('holiday')->comment('休日')->nullable();//
            $table->string('long_vacation')->comment('長期休暇')->nullable();//
            $table->text('holiday_remarks')->comment('休日備考')->nullable();//
            $table->string('working_hours_1')->comment('勤務時間①')->nullable();//
            $table->string('actual_working_hours_1')->comment('実働時間①')->nullable();//
            $table->string('break_time_1')->comment('休憩時間①')->nullable();//
            $table->string('overtime')->comment('残業(時間/月)')->nullable();//
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
            $table->string('commuting_by_car')->comment('車通勤（可能）')->nullable();
            $table->text('traffic_commuting_remarks')->comment('交通通勤備考')->nullable();
            $table->string('parking')->comment('駐車場')->nullable();
            $table->string('posting_site')->comment('求人掲載サイト')->nullable();
            $table->string('status')->comment('作成ステータス')->nullable();
            $table->date('order_date')->comment('起算日')->nullable();
            $table->string('after_introduction')->comment('紹介後')->nullable();
            $table->string('timing_of_switching')->comment('直接雇用切替時期')->nullable();
            $table->string('monthly_lower_limit')->comment('月収例（下限）')->nullable();
            $table->string('monthly_upper_limit')->comment('月収例（上限）')->nullable();
            $table->string('annual_lower_limit')->comment('年収例（下限）')->nullable();
            $table->string('age_upper_limit')->comment('年齢（上限）')->nullable();
            $table->string('bonuses_treatment')->comment('賞与等・待遇')->nullable();
            $table->string('holidays_vacations')->comment('休日・休暇')->nullable();
            $table->text('introduction_others')->comment('その他')->nullable();
            $table->string('qualification', 10)->comment('資格要件（0:不問、1:歓迎、2:必須）')->nullable();
            $table->string('qualification_content', 100)->comment('資格名')->nullable();
            $table->string('experience', 10)->comment('経験要件（0:不問、1:歓迎、2:必須）')->nullable();
            $table->string('experience_content', 10)->comment('経験内容')->nullable();
            $table->string('sex', 10)->comment('性別要件（0:不問、1:歓迎、2:必須）')->nullable();
            $table->string('age', 100)->comment('年齢要件')->nullable();
            $table->string('uniform_supply', 10)->comment('制服支給の有無（0:なし, 1:あり（有料), あり（無料））')->nullable();
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
        Schema::dropIfExists('draft_job_offers');
    }
}
