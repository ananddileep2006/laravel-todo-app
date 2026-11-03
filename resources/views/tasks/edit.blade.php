```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>

    <style>
        body {
            background: #f4f6fb;
            font-family: Arial, sans-serif;
            padding: 40px 20px;
        }

        .container {
            max-width: 550px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 14px;
        }

        input, textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 13px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        textarea {
            min-height: 100px;
        }

        button, a {
            padding: 11px 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
        }

        button {
            background: #5b61e8;
            color: white;
        }

        a {
            background: #eee;
            color: #333;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
<div class="container">

    <h1>Edit Task ✏️</h1>

    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Task Title</label>

        <input type="text" name="title"
               value="{{ old('title', $task->title) }}">

        @error('title')
            <p class="error">{{ $message }}</p>
        @enderror

        <label>Description</label>

        <textarea name="description">{{ old('description', $task->description) }}</textarea>

        @error('description')
            <p class="error">{{ $message }}</p>
        @enderror

        <button type="submit">Update Task</button>

        <a href="{{ route('tasks.index') }}">Cancel</a>

    </form>

</div>
</body>
</html>
```