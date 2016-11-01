<?php

use yii\db\Migration;

class m161020_194928_employee_structure extends Migration
{
      /*
    public function up()
    {

    }

    public function down()
    {
        echo "m160827_220327_employee_structure cannot be reverted.\n";

        return false;
    }

    */
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
      // $this->createTable('{{%gender}}', [
      //   'gender_id' => $this->primaryKey(),
      //   'gender_type' => $this->smallInteger()->notNull()->defaultValue(0),
      // ]);
      //   $this->createTable('{{%employees}}', [
      //     'emp_no' => $this->primaryKey(),
      //     'birth_date' => $this->date(),
      //     'first_name' => $this->string(64)->notNull(),
      //     'last_name' => $this->string(64)->notNull(),
      //     'gender' => $this->integer()->notNull(),
      //     'hire_date' => $this->date()->notNull(),
      //     'termination_date' => $this->date(),
      //   ]);
        $this->createTable('{{%salary}}', [
          'salary_id' => $this->primaryKey(),
          'emp_id' => $this->integer(),
          'salary' => $this->integer(),
          'from_date' => $this->date(),
          'to_date' => $this->date(),
        ]);
        $this->createTable('{{%dept_emp}}', [
          'dept_id' => $this->primaryKey(),
          'emp_id' => $this->integer(),
          'from_date' => $this->date(),
          'to_date' => $this->date(),
        ]);
        $this->createTable('{{%departments}}', [
          'dept_no' => $this->primaryKey()->string(4),
          'dept_name' => $this->string(40),
       ]);
       $this->createTable('{{%dept_manager}}', [
         'dept_manager_id' => $this->primaryKey(),
         'emp_id' => $this->integer(),
         'dept_no' => $this->string(4),
         'from_date' => $this->date(),
         'to_date' => $this->date(),
      ]);
      $this->createTable('{{%titles}}', [
        'title_id' => $this->primaryKey(),
        'emp_id' => $this->integer(),
        'title' => $this->string(50),
        'from_date' => $this->date(),
        'to_date' => $this->date(),
     ]);
        //$this->addForeignKey('fk_status_log_updated_by', '{{%status_log}}', 'updated_by', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
      //$this->dropForeignKey('fk_gender_id','{{%employees}}');
      $this->dropTable('{{%employees}}');
      $this->dropTable('{{%gender}}');
      $this->dropTable('{{%salaries}}');
      $this->dropTable('{{%dept_emp}}');
      $this->dropTable('{{%departments}}');
      $this->dropTable('{{%dept_manager}}');
      $this->dropTable('{{%titles}}');
      //$this->dropTable('{{%gender}}');
    }

}
