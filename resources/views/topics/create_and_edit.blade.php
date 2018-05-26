@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-body">
                <h2 class="text-center">
                    <i class="glyphicon glyphicon-edit"></i>
                    @if($topic->id)
                        编辑话题
                    @else
                        新建话题
                    @endif
                </h2>
                 @include('common.error')
                <hr>
                @if($topic->id)
                    <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                        <input type="hidden" name="_method" value="PUT">
                @else
                    <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
                @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">


                <div class="form-group">
                	<input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $topic->title ) }}" placeholder="请输入帖子标题" required/>
                </div>
                <div class="form-group">
                        <select class="form-control" name="category_id" required>
                            <option value="" hidden disabled selected>请选择分类</option>
                            @foreach ($categories as $value)
                                <option value="{{ $value->id }}" @if($topic->category_id==$value->id) selected @endif>{{ $value->name }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="form-group">
                	<textarea name="body" class="form-control" id="editor" rows="3" placeholder="请填入至少三个字符的内容。" required>{{ old('body', $topic->body ) }}</textarea>
                </div>
                <!-- <div class="form-group">
                	<textarea name="excerpt" id="excerpt-field" class="form-control" placeholder="请输入摘要" rows="3">{{ old('excerpt', $topic->excerpt ) }}</textarea>
                </div> -->
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">保存</button>
                    <a class="btn btn-link pull-right" href="{{ route('topics.index') }}"><i class="glyphicon glyphicon-backward"></i>  返回</a>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection