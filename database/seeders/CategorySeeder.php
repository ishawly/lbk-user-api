<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Record;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 分类,10000以下系统设置,以上为用户自定义
        $categories = [
            '餐饮',
            '服饰美容',
            '宠物',
            '亲子',
            '购物',
            '出行',
            '酒店',
            '休闲娱乐',
            '教育',
            '公益',
            '生活日用',
            '医疗健康',
            '充值缴费',
            '房租房贷',
            '保险',
            '现金',
            '转账给他人',
            '红包',
            '手续费',
            '还款',
            '债券',
            '理财产品',
            '定期',
            '外汇',
            '贵金属',
            '股票',
        ];
        $this->addItem($categories, 1, Record::TYPE_SUB);

        // 其他
        $other = [
            '其他',
        ];
        $this->addItem($other, 5000, Record::TYPE_SUB);

        $categories = [
            '工资',
            '收款',
            '债券',
            '理财产品',
            '定期',
            '外汇',
            '贵金属',
            '股票',
        ];
        $this->addItem($categories, 5001, Record::TYPE_ADD);
        $this->addItem($other, 10000, Record::TYPE_ADD);
    }

    private function addItem($categories, $startId, $type)
    {
        $num = 1;
        foreach ($categories as $c) {
            $data = [
                'name' => $c,
                'type' => $type,
            ];
            1 === $num and $data['id'] = $startId;
            Category::factory()->create($data);

            ++$num;
        }
    }
}
