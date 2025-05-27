<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Task extends Model implements HasMedia
{

    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;
    use InteractsWithMedia;
    
    protected $fillable = [
        'name', 
        'is_completed',
        'due_date',
    ];

    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
            'due_date' => 'date',
        ];
    }

    protected $appends = [
        'mediaFile'
    ];


    // Em App\Models\Task.php
    public function getMediaFileAttribute()
    {
        // Verifica se a relação 'media' foi carregada (o que ->with('media') faz)
        if ($this->relationLoaded('media')) {
            // Tenta obter o primeiro item da coleção 'default' (ou a coleção que você usou ao salvar)
            $mediaItem = $this->getFirstMedia(); // Ou $this->getFirstMedia('nome_da_sua_colecao_se_nao_for_default')

            if ($mediaItem) {
                return [
                    'original_url' => $mediaItem->getFullUrl() // Retorna a URL completa
                ];
            }
        }
        return null; // Retorna null se não houver mídia ou a relação não estiver carregada
    }

    public function taskCategories(): BelongsToMany
    {
        return $this->belongsToMany(TaskCategory::class);
    }
}
