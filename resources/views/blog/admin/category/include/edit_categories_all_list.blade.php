
@foreach($categories as $category)
    <option value="{{$category->id ?? ""}}"
        @isset($item->id)
            @if($category->id == $item->parent_id) selected @endif
            @if($category->id == $item->id) disabled
            @endif
      >
        @endisset
            {!! $delimiter ?? "" !!} {{$category->title ?? ""}}
    </option>
    @if(count($category->children))
        @include('blog.admin.category.include.edit_categories_all_list',
        ['categories' => $category->children,
         'delimiter' => ' - '.$delimiter,
        ])
        @endif
@endforeach