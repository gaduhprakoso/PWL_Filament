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

                // 1. Fields Kiri (Mengambil 2/3 bagian dari total 3 kolom)
                ComponentsSection::make("Post Details")
                    ->description("Isi detail utama postingan di sini")
                    ->icon('heroicon-o-document-text') // Tugas 2: Icon Section 1
                    ->schema([

                        // Tugas 3: Buat tampilan lebih rapi (2 kolom untuk field utama)
                        ComponentsGroup::make([
                            TextInput::make("title")
                                ->required(),
                            TextInput::make("slug")
                                ->required(),
                            Select::make("category_id")
                                ->relationship("category", "name")
                                ->preload()
                                ->searchable(),
                            ColorPicker::make("color"),
                        ])->columns(2),

                        MarkdownEditor::make("content")
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2), // Tugas 1: Layout Kiri (2/3)

                // 2. Meta Kanan (Mengambil 1/3 bagian sisanya)
                ComponentsGroup::make([

                    // Section Image
                    ComponentsSection::make("Post Details")
                        ::make("Media")
                        ->icon('heroicon-o-photo') // Tugas 2: Icon Section 2
                        ->schema([
                            FileUpload::make("image")
                                ->disk("public")
                                ->directory("posts"),
                        ]),

                    // Section Meta Informasi
                    ComponentsSection::make("Post Details")
                        ::make("Meta Information")
                        ->icon('heroicon-o-information-circle') // Tugas 2: Icon Section 3
                        ->schema([
                            TagsInput::make("tags"),
                            Checkbox::make("published"),
                            DateTimePicker::make("published_at"),
                        ]),

                ])->columnSpan(1), // Tugas 1: Layout Kanan (1/3)

            ])->columns(3); // Dasar grid 3 kolom untuk pembagian 2/3 dan 1/3
    }
}
