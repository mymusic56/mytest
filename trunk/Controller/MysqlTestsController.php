<?php
App::uses('AppController', 'Controller');
/**
 * 设置事务隔离级别
 * SET [SESSION | GLOBAL] TRANSACTION ISOLATION LEVEL {READ UNCOMMITTED | READ COMMITTED | REPEATABLE READ | SERIALIZABLE}
 * @author zhangshengji
 *
 */
class MysqlTestsController extends AppController{
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}
	public function addLock(){
		
	}
	public function transactionIsolation(){
		/**
		 * 聚簇索引--物理索引
		 * READ COMMITTED
		 * 
		 * REPEATABLE READ ：in the same transaction, the data your get is the same
		 * 
		 * SERIALIZABLE : the read always will be locked
		 * 
		 * 在MySQL/InnoDB中，所谓的读不加锁，并不适用于所有的情况，而是隔离级别相关的。Serializable隔离级别，
		 * 读不加锁就不再成立，所有的读操作，都是当前读。
		 */
		
		/**
		 * the default transaction isolation level is REPEATABLE-READ
		 * set session transaction isolation level read uncommitted;
		 * 
		 * set global transaction isolation level read uncommitted;
		 * 
		 * 
		 * select @@tx_isolation;
		 * 
		 * 
		 */
		
		/**
		 * dead lock
		 * 
		了解数据库的一些基本理论知识：数据的存储格式 (堆组织表 vs 聚簇索引表)；并发控制协议 (MVCC vs Lock-Based CC)；Two-Phase Locking；数据库的隔离级别定义 (Isolation Level)；
		了解SQL本身的执行计划 (主键扫描 vs 唯一键扫描 vs 范围扫描 vs 全表扫描)；
		了解数据库本身的一些实现细节 (过滤条件提取；Index Condition Pushdown；Semi-Consistent Read)；
		了解死锁产生的原因及分析的方法 (加锁顺序不一致；分析每个SQL的加锁顺序)
		 */
	}
}