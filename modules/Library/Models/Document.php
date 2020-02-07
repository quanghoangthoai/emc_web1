<?php

namespace Modules\Library\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Document extends Model
{
    use Filterable;
    protected $table = 'library_documents';

    protected $fillable = [
        'id',
        'name',
        'document_type',
        'category_id',
        'slug',
        'view_count',
        'download_count',
        'short_description',
        'content',
        'image',
        'attach_file',
        'status',
        'created_at',
        'name',
        'document_type',
        'category_id',
        'text_code',
        'text_type',
        'issued_date',
        'started_date',
        'expired_date',
        'issued_location',
        'video_url'
    ];

    protected $filterable = [
        'name',
        'documentType' => 'document_type',
        'categoryId' => 'categoryid',
        'startDate' => 'created_at',
        'endDate' => 'created_at'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function history()
    {
        return $this->hasMany(History::class, 'document_id');
    }

    public function filterName($query, $value)
    {

        return $query->where('name', 'LIKE', '%' . $value . '%');
    }

    public function filterDocumentType($query, $value)
    {

        return $query->where('document_type', $value);
    }

    public function filterCategoryId($query, $value)
    {

        return $query->where('category_id', $value);
    }

    public function filterStartDate($query, $value)
    {
        if ($value)
            return $query->where('created_at', '>=', Carbon::parse($value));
    }
    public function filterEndDate($query, $value)
    {
        if ($value)
            return $query->where('created_at', '<=', Carbon::parse($value)->addDay());
    }
}
