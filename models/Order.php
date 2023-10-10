<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_tb".
 *
 * @property int $id
 * @property string $order_no
 * @property int $user_id
 * @property int|null $payment_id
 * @property float $shipping_charge
 * @property float $total_amount
 * @property string $order_date
 * @property string $status
 *
 * @property Payment $payment
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_tb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_no', 'user_id', 'shipping_charge', 'total_amount', 'status'], 'required'],
            [['user_id', 'payment_id'], 'integer'],
            [['shipping_charge', 'total_amount'], 'number'],
            [['order_date'], 'safe'],
            [['order_no', 'status'], 'string', 'max' => 100],
            [['order_no'], 'unique'],
            [['payment_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentTb::className(), 'targetAttribute' => ['payment_id' => 'payment_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_no' => 'Order No',
            'user_id' => 'User ID',
            'payment_id' => 'Payment ID',
            'shipping_charge' => 'Shipping Charge',
            'total_amount' => 'Total Amount',
            'order_date' => 'Order Date',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Payment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(Payment::className(), ['payment_id' => 'payment_id']);
    }

}
