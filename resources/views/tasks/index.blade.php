```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow | My Dashboard</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #0b1120;
            color: #e5e7eb;
            padding: 35px 20px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        header h1 {
            font-size: 30px;
            color: #fff;
        }

        header span {
            color: #38bdf8;
        }

        .subtitle {
            color: #94a3b8;
            margin-top: 8px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 22px;
        }

        .summary-card, .panel, .task-card {
            background: #151f32;
            border: 1px solid #26354d;
            border-radius: 14px;
            padding: 22px;
        }

        .summary-card h2 {
            color: #38bdf8;
            font-size: 30px;
            margin-bottom: 8px;
        }

        .summary-card p, .muted {
            color: #94a3b8;
        }

        .panel {
            margin-bottom: 22px;
        }

        .panel h2 {
            margin-bottom: 16px;
            color: #fff;
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #cbd5e1;
        }

        .progress-track {
            height: 10px;
            background: #26354d;
            border-radius: 20px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #2563eb, #38bdf8);
            border-radius: 20px;
        }

        input, textarea {
            width: 100%;
            padding: 13px;
            margin: 9px 0;
            background: #0b1120;
            color: white;
            border: 1px solid #334155;
            border-radius: 8px;
            font-size: 15px;
        }

        input:focus, textarea:focus {
            outline: 1px solid #38bdf8;
        }

        textarea {
            min-height: 80px;
            resize: vertical;
        }

        button, .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .add-btn {
            background: #2563eb;
            color: white;
        }

        .add-btn:hover {
            background: #1d4ed8;
        }

        .complete-btn {
            background: #164e63;
            color: #67e8f9;
        }

        .edit-btn {
            background: #713f12;
            color: #fde68a;
        }

        .delete-btn {
            background: #7f1d1d;
            color: #fecaca;
        }

        .task-card {
            margin-bottom: 14px;
        }

        .task-title {
            color: white;
            font-size: 18px;
            margin-bottom: 9px;
        }

        .task-description {
            color: #94a3b8;
            margin-bottom: 16px;
            overflow-wrap: anywhere;
        }

        .completed {
            text-decoration: line-through;
            color: #64748b;
        }

        .task-actions {
            display: flex;
            gap: 9px;
            flex-wrap: wrap;
        }

        .filters {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .filter-btn {
            background: #1e293b;
            color: #cbd5e1;
            border: 1px solid #334155;
        }

        .filter-btn.active {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        .success {
            background: #064e3b;
            color: #a7f3d0;
            padding: 13px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .error {
            color: #fca5a5;
            font-size: 13px;
        }

        .empty {
            text-align: center;
            color: #94a3b8;
            padding: 30px;
        }

        .task-status {
            color: #38bdf8;
            font-size: 12px;
            margin-bottom: 10px;
        }

        @media(max-width: 600px) {
            .summary {
                grid-template-columns: 1fr;
            }

            header {
                align-items: flex-start;
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    @php
        $total = $tasks->count();
        $completed = $tasks->where('is_completed', true)->count();
        $pending = $total - $completed;
        $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
    @endphp

    <header>
        <div>
            <h1>Task<span>Flow.</span></h1>
            <p class="subtitle">Plan your work. Achieve your goals.</p>
        </div>
        <p class="muted">MY DASHBOARD</p>
    </header>

    <div class="summary">
        <div class="summary-card">
            <h2>{{ $total }}</h2>
            <p>Total Tasks</p>
        </div>

        <div class="summary-card">
            <h2>{{ $pending }}</h2>
            <p>Pending Tasks</p>
        </div>

        <div class="summary-card">
            <h2>{{ $completed }}</h2>
            <p>Completed Tasks</p>
        </div>
    </div>

    <div class="panel">
        <div class="progress-info">
            <strong>Overall Progress</strong>
            <span>{{ $percentage }}%</span>
        </div>

        <div class="progress-track">
            <div class="progress-fill"
                 style="width: {{ $percentage }}%">
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    <div class="panel">
        <h2>+ Add New Task</h2>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <input type="text" name="title"
                   placeholder="What do you need to do?"
                   value="{{ old('title') }}">

            @error('title')
                <p class="error">{{ $message }}</p>
            @enderror

            <textarea name="description"
                      placeholder="Add a description (optional)">{{ old('description') }}</textarea>

            @error('description')
                <p class="error">{{ $message }}</p>
            @enderror

            <button type="submit" class="add-btn">Add Task</button>
        </form>
    </div>

    <div class="panel">
        <h2>Your Tasks</h2>

        <input type="text" id="searchInput"
               placeholder="Search tasks...">

        <div class="filters">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="pending">Pending</button>
            <button class="filter-btn" data-filter="completed">Completed</button>
        </div>

        @forelse($tasks as $task)

            <div class="task-card"
                 data-status="{{ $task->is_completed ? 'completed' : 'pending' }}"
                 data-title="{{ strtolower($task->title) }}">

                <p class="task-status">
                    {{ $task->is_completed ? 'COMPLETED' : 'PENDING' }}
                </p>

                <h3 class="task-title {{ $task->is_completed ? 'completed' : '' }}">
                    {{ $task->title }}
                </h3>

                <p class="task-description">
                    {{ $task->description ?: 'No description provided.' }}
                </p>

                <div class="task-actions">

                    <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <button type="submit" class="complete-btn">
                            {{ $task->is_completed ? 'Mark Pending' : 'Mark Completed' }}
                        </button>
                    </form>

                    <a href="{{ route('tasks.edit', $task) }}"
                       class="btn edit-btn">Edit</a>

                    <form action="{{ route('tasks.destroy', $task) }}"
                          method="POST"
                          onsubmit="return confirm('Delete this task?')">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="delete-btn">Delete</button>
                    </form>

                </div>
            </div>

        @empty
            <div class="empty">
                <h3>No tasks yet!</h3>
                <p>Add your first task above.</p>
            </div>
        @endforelse

        <p id="noResults" class="empty" style="display:none;">
            No matching tasks found.
        </p>

    </div>

</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const taskCards = document.querySelectorAll('.task-card[data-status]');
    const noResults = document.getElementById('noResults');

    let currentFilter = 'all';

    function filterTasks() {
        const searchText = searchInput.value.toLowerCase();
        let visibleCount = 0;

        taskCards.forEach(card => {
            const title = card.dataset.title;
            const status = card.dataset.status;

            const matchesSearch = title.includes(searchText);
            const matchesFilter =
                currentFilter === 'all' || status === currentFilter;

            const show = matchesSearch && matchesFilter;

            card.style.display = show ? 'block' : 'none';

            if (show) visibleCount++;
        });

        noResults.style.display =
            visibleCount === 0 && taskCards.length > 0 ? 'block' : 'none';
    }

    searchInput.addEventListener('input', filterTasks);

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            currentFilter = button.dataset.filter;

            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            filterTasks();
        });
    });
</script>

</body>
</html>
```