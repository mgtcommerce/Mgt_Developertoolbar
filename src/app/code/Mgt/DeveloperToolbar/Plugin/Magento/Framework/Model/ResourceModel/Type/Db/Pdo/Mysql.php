<?php
namespace Mgt\DeveloperToolbar\Plugin\Magento\Framework\Model\ResourceModel\Type\Db\Pdo;

class Mysql
{
    public function aroundGetConnection(
        \Magento\Framework\Model\ResourceModel\Type\Db\Pdo\Mysql $subject,
        \Closure $proceed,
        \Magento\Framework\DB\LoggerInterface $logger
    ) {
        /** @var \Magento\Framework\DB\Adapter\Pdo\Mysql $return */
        $return = $proceed($logger);

        if ($return instanceof \Magento\Framework\DB\Adapter\Pdo\Mysql) {
            $return->getProfiler()->setEnabled(true);
        }

        return $return;
    }
}