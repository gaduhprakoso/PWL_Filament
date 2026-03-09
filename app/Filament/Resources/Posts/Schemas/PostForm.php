<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Group as ComponentsGroup;
use Filament\Schemas\Components\Section as ComponentsSection;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // 1. Fields Kiri (2/3 Kolom)
                ComponentsSection::make("Post Details")
                    ->description("Isi detail utama postingan di sini")
                    ->icon('heroicon-o-document-text')
                    ->schema([

                        ComponentsGroup::make([
                            // Validasi Title: Minimal 5 karakter + Custom Message
                            TextInput::make("title")
                                ->required()
                                ->minLength(5)
                                ->validationMessages([
                                    'minLength' => 'Judulnya trtlslu pendek, minimal 5 karakter',
                                    'required' => 'Judul tidak boleh kosong.',
                                ]),

                            // Validasi Slug: Unik, Minimal 3 karakter + Custom Message
                            TextInput::make("slug")
                                ->required()
                                ->minLength(3)
                                ->unique(ignoreRecord: true)
                                ->validationMessages([
                                    'unique' => 'Waduh, slug ini sudah dipakai postingan lain.',
                                    'minLength' => 'Slug minimal 3 karakter.',
                                ]),

                            // Validasi Category: Wajib dipilih
                            Select::make("category_id")
                                ->relationship("category", "name")
                                ->preload()
                                ->required()
                                ->searchable(),

                            ColorPicker::make("color"),
                        ])->columns(2),

                        MarkdownEditor::make("content")
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2),

                // 2. Meta Kanan (1/3 Kolom)
                ComponentsGroup::make([

                    // Section Media - Validasi Image: Wajib diupload
                    ComponentsSection::make("Media")
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make("image")
                                ->required()
                                ->disk("public")
                                ->directory("posts"),
                        ]),

                    // Section Meta Informasi
                    ComponentsSection::make("Meta Information")
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            TagsInput::make("tags"),
                            Checkbox::make("published"),
                            DateTimePicker::make("published_at"),
                        ]),

                ])->columnSpan(1),

            ])->columns(3);
    }
}