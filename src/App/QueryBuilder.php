<?php declare(strict_types=1);

namespace Tm\Admin\App;
use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder {

    private $pdo, $queryFactory;

    function __construct(PDO $pdo, QueryFactory $queryFactory)
    {
        $this->pdo = $pdo;
        $this->queryFactory = $queryFactory;
    }

    public function getAll(string $table): array
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])->from($table);   
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne(string $table, int $id): array 
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['*'])->from($table)->where('id = :id', ['id' => $id]);   
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    public function insert(string $table, array $data): void 
    {
        $insert = $this->queryFactory->newInsert();
        $insert->into($table)
                ->cols($data);
        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());

    }

    public function update(string $table, int $id, array $data): void 
    {
        $update = $this->queryFactory->newUpdate();
        $update->table($table)                  
            ->cols($date)
            ->where('id = :id')           
            ->bindValue('id', $id);
        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }

    public function delete(string $table, int $id): void 
    {
        $delete = $this->queryFactory->newDelete();
        $delete->from($table)
                ->where('id = :id')
                ->bindValue('id', $id);
        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());
    }

}