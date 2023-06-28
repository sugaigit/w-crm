<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBranchRelationInfoToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('branch_2')->comment('支店②')->nullable();
            $table->string('department_2')->comment('担当者所属部署②')->nullable();
            $table->string('manager_name_2')->comment('担当者名②')->nullable();
            $table->string('address_2')->comment('顧客住所②')->nullable();
            $table->string('phone_2')->comment('電話番号②')->nullable();
            $table->string('email_2')->comment('メールアドレス②')->nullable();
            $table->string('fax_2')->comment('FAX②')->nullable();

            $table->string('branch_3')->comment('支店③')->nullable();
            $table->string('department_3')->comment('担当者所属部署③')->nullable();
            $table->string('manager_name_3')->comment('担当者名③')->nullable();
            $table->string('address_3')->comment('顧客住所③')->nullable();
            $table->string('phone_3')->comment('電話番号③')->nullable();
            $table->string('email_3')->comment('メールアドレス③')->nullable();
            $table->string('fax_3')->comment('FAX③')->nullable();

            $table->string('branch_4')->comment('支店④')->nullable();
            $table->string('department_4')->comment('担当者所属部署④')->nullable();
            $table->string('manager_name_4')->comment('担当者名④')->nullable();
            $table->string('address_4')->comment('顧客住所④')->nullable();
            $table->string('phone_4')->comment('電話番号④')->nullable();
            $table->string('email_4')->comment('メールアドレス④')->nullable();
            $table->string('fax_4')->comment('FAX④')->nullable();

            $table->string('branch_5')->comment('支店⑤')->nullable();
            $table->string('department_5')->comment('担当者所属部署⑤')->nullable();
            $table->string('manager_name_5')->comment('担当者名⑤')->nullable();
            $table->string('address_5')->comment('顧客住所⑤')->nullable();
            $table->string('phone_5')->comment('電話番号⑤')->nullable();
            $table->string('email_5')->comment('メールアドレス⑤')->nullable();
            $table->string('fax_5')->comment('FAX⑤')->nullable();

            $table->string('branch_6')->comment('支店⑥')->nullable();
            $table->string('department_6')->comment('担当者所属部署⑥')->nullable();
            $table->string('manager_name_6')->comment('担当者名⑥')->nullable();
            $table->string('address_6')->comment('顧客住所⑥')->nullable();
            $table->string('phone_6')->comment('電話番号⑥')->nullable();
            $table->string('email_6')->comment('メールアドレス⑥')->nullable();
            $table->string('fax_6')->comment('FAX⑥')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('branch_2');
            $table->dropColumn('department_2');
            $table->dropColumn('manager_name_2');
            $table->dropColumn('address_2');
            $table->dropColumn('phone_2');
            $table->dropColumn('email_2');
            $table->dropColumn('fax_2');

            $table->dropColumn('branch_3');
            $table->dropColumn('department_3');
            $table->dropColumn('manager_name_3');
            $table->dropColumn('address_3');
            $table->dropColumn('phone_3');
            $table->dropColumn('email_3');
            $table->dropColumn('fax_3');

            $table->dropColumn('branch_4');
            $table->dropColumn('department_4');
            $table->dropColumn('manager_name_4');
            $table->dropColumn('address_4');
            $table->dropColumn('phone_4');
            $table->dropColumn('email_4');
            $table->dropColumn('fax_4');

            $table->dropColumn('branch_5');
            $table->dropColumn('department_5');
            $table->dropColumn('manager_name_5');
            $table->dropColumn('address_5');
            $table->dropColumn('phone_5');
            $table->dropColumn('email_5');
            $table->dropColumn('fax_5');

            $table->dropColumn('branch_6');
            $table->dropColumn('department_6');
            $table->dropColumn('manager_name_6');
            $table->dropColumn('address_6');
            $table->dropColumn('phone_6');
            $table->dropColumn('email_6');
            $table->dropColumn('fax_6');
        });
    }
}
