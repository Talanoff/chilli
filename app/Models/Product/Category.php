<?php

namespace App\Models\Product;

use App\Traits\Sluggable;
use Bigperson\Exchange1C\Interfaces\GroupInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model implements GroupInterface
{
    use Sluggable;

    protected $fillable = [
        'slug',
        'title',
    ];

    protected $with = [
        'product'
    ];

    /**
     * @return HasMany
     */
    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Создание дерева групп
     * в параметр передаётся массив всех групп (import.xml > Классификатор > Группы)
     * $groups[0]->parent - родительская группа
     * $groups[0]->children - дочерние группы.
     *
     * @param \Zenwalker\CommerceML\Model\Group[] $groups
     *
     * @return void
     */
    public static function createTree1c($groups)
    {
        // TODO: Implement createTree1c() method.
    }

    /**
     * Возвращаем имя поля в базе данных, в котором хранится ID из 1с
     *
     * @return string
     */
    public static function getIdFieldName1c()
    {
        // TODO: Implement getIdFieldName1c() method.
    }

    /**
     * Возвращаем id сущности.
     *
     * @return int|string
     */
    public function getPrimaryKey()
    {
        // TODO: Implement getPrimaryKey() method.
    }
}
