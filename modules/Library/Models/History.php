<?php

namespace Modules\Library\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;

class History extends Model
{
    use Filterable;
    protected $table = 'library_histories';

    protected $fillable = [
        'id',
        'user_id',
        'document_id',
        'category_id',
        'download_count',
        'download_time',
        'status'
    ];

    protected $filterable = [
        'name',
        'documentType' => 'document_type',
        'categoryId' => 'category_id',
        'startDate' => 'dowload_time',
        'endDate' => 'dowload_time'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function category()
    {
        return $this->beLongsTo(Category::class, 'category_id');
    }
    public function user()
    {
        return $this->beLongsTo(User::class, 'user_id');
    }




    public function filterName($query, $value)
    {

        return $query->join('library_documents', 'library_histories.document_id', '=', 'library_documents.id')->where('library_documents.name', 'LIKE', '%' . $value . '%')->select('library_histories.*');
    }

    public function filterDocumentType($query, $value)
    {

        return $query->where('document_type', $value);
    }

    public function filterCategoryId($query, $value)
    {

        return $query->where('library_histories.category_id', $value);
    }

    public function filterStartDate($query, $value)
    {
        if ($value)
            return $query->where('dowload_time', '>=', Carbon::parse($value));
    }
    public function filterEndDate($query, $value)
    {
        if ($value)
            return $query->where('dowload_time', '<=', Carbon::parse($value)->addDay());
    }
}