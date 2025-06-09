<style>
:root {
    --bs-primary: {{ $tema->bs_primary ?? '#101820' }};
    --bs-success: {{ $tema->bs_success ?? '#198754' }};
    --bs-danger: {{ $tema->bs_danger ?? '#d30d0d' }};

    --primary-focus: {{ $tema->primary_focus ?? '#2d3e50' }};
    --border-primary-focus: {{ $tema->border_primary_focus ?? '#1f2a35' }};
    --primary-gradient: {{ $tema->primary_gradient ?? '#1c5d9e' }};

    --success-focus: {{ $tema->success_focus ?? '#4b7148' }};
    --border-success-focus: {{ $tema->border_success_focus ?? '#2b4c28' }};
    --success-gradient: {{ $tema->success_gradient ?? '#5f8a5b' }};

    --danger-focus: {{ $tema->danger_focus ?? '#e63333' }};
    --border-danger-focus: {{ $tema->border_danger_focus ?? '#a50a0a' }};
    --danger-gradient: {{ $tema->danger_gradient ?? '#f55f5f' }};
}
</style>
