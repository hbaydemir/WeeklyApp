@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 mb-3">
            <h4>Filters</h4>
            <div class="card">
                <div class="card-body">
                  <form method="GET" action="{{ route('home') }}">
                    <div class="form-group">
                        <label for="choosePlan">Select a Plan</label>
                        <select class="form-select form-select-sm" id="choosePlan" name="plan_id">
                            <option value="" {{ request('plan_id') == null ? 'selected' : '' }}>Today's Quests</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ request('plan_id') == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="form-group mt-2">
                        <label for="questDate">Date</label>
                        <input 
                            type="date" 
                            class="form-control form-control-sm" 
                            id="questDate" 
                            name="date" 
                            value="{{ request('date') }}" 
                            placeholder="Date">
                    </div>
                
                    <div class="form-group mt-2">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="show_old_quests" 
                            value="1" 
                            id="flexCheckDefault"
                            {{ request('show_old_quests') ? 'checked' : '' }}>
                        <label class="form-check-label user-select-none" for="flexCheckDefault">
                            Show Old Quests
                        </label>
                    </div>
                
                    <div class="form-group mt-2">
                        <button type="submit" class="btn btn-sm btn-primary">&nbsp; Filter &nbsp;</button>
                    </div>
                </form>
                
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
          <h4>Progress</h4>
          <div class="card">
              <div class="card-body">
                <label for="Waiting">Waiting</label>
                <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="{{ $waitingPercentage }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-warning text-dark" style="width: {{ $waitingPercentage }}%">
                        {{ round($waitingPercentage) }}%
                    </div>
                </div>

                <label class="mt-3" for="Completed">Completed</label>
                <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="{{ $completedPercentage }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-primary" style="width: {{ $completedPercentage }}%">
                        {{ round($completedPercentage) }}%
                    </div>
                </div>

                <label class="mt-3" for="NotCompleted">Not Completed</label>
                <div class="progress" role="progressbar" aria-label="Danger example" aria-valuenow="{{ $notCompletedPercentage }}" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-danger" style="width: {{ $notCompletedPercentage }}%">
                        {{ round($notCompletedPercentage) }}%
                    </div>
                </div>



                
              </div>
          </div>
      </div>

        <div class="col-md-12 mb-4">
          <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#createPlanModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
            </svg>
            Create New Plan
          </button>
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createQuestModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
              <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
            </svg>
            Create New Quest
          </button>
        </div>
        <div class="col-md-12">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Quest</th>
                    <th scope="col">Description</th>
                    <th scope="col">Plan</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quests as $quest)
                    @php
                        $rowClass = '';
                        if ($quest->status === 'completed') {
                            $rowClass = 'table-success';
                        } elseif ($quest->status === 'not_completed') {
                            $rowClass = 'table-danger';
                        } elseif ($quest->due_date == today()->toDateString()) {
                            $rowClass = 'table-warning';
                        } else {
                            $rowClass = 'table-secondary';
                        }
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <th scope="row">{{ $quest->due_date }}</th>
                        <td>{{ $quest->title }}</td>
                        <td>{{ $quest->description }}</td>
                        <td>{{ $quest->plan->name ?? 'No Plan' }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                  <!-- Completed Butonu -->
                                  <form method="POST" action="{{ route('quests.updateStatus', $quest->id) }}">
                                      @csrf
                                      <input type="hidden" name="status" value="completed">
                                      <button type="submit" class="btn btn-sm btn-primary">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-all" viewBox="0 0 16 16">
                                              <path d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486z"/>
                                          </svg>
                                      </button>
                                  </form>
                              
                                  <!-- Not Completed Butonu -->
                                  <form method="POST" action="{{ route('quests.updateStatus', $quest->id) }}" class="ms-1">
                                      @csrf
                                      <input type="hidden" name="status" value="not_completed">
                                      <button type="submit" class="btn btn-sm btn-danger">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                              <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                          </svg>
                                      </button>
                                  </form>
                                </div>
                            

                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                            <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu">
                                      <li>
                                        <button type="button" class="dropdown-item" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editQuestModal"
                                                data-id="{{ $quest->id }}"
                                                data-title="{{ $quest->title }}"
                                                data-description="{{ $quest->description }}"
                                                data-plan="{{ $quest->plan_id }}"
                                                data-date="{{ $quest->due_date }}">
                                          Edit
                                        </button>
                                      </li>

                                      <li>
                                        <button type="button" class="dropdown-item text-danger" onclick="confirmDelete({{ $quest->id }})">
                                          Delete
                                        </button>
                                        <form id="delete-form-{{ $quest->id }}" method="POST" action="{{ route('quests.destroy', $quest->id) }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                      </li>
                                      
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        </div>
    </div>
</div>

<section class="modals">
  <!-- Create New Plan Modal -->
  <div class="modal fade" id="createPlanModal" tabindex="-1" aria-labelledby="createPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createPlanModalLabel">Create New Plan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="createPlanForm" method="POST" action="{{ route('plans.store') }}">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="planName" class="form-label">Plan Name</label>
              <input type="text" class="form-control" id="planName" name="name" placeholder="Enter plan name" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Plan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Create New Quest Modal -->
  <div class="modal fade" id="createQuestModal" tabindex="-1" aria-labelledby="createQuestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createQuestModalLabel">Create New Quest</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="createQuestForm" method="POST" action="{{ route('quests.store') }}">
          @csrf
          <div class="modal-body">
            <div class="mb-3">
              <label for="questTitle" class="form-label">Quest Title</label>
              <input type="text" class="form-control" id="questTitle" name="title" placeholder="Enter quest title" required>
            </div>
            <div class="mb-3">
              <label for="questDescription" class="form-label">Description</label>
              <textarea class="form-control" id="questDescription" name="description" rows="3" placeholder="Enter quest description"></textarea>
            </div>
            <div class="mb-3">
              <label for="questPlan" class="form-label">Select Plan</label>
              <select class="form-control" id="questPlan" name="plan_id" required>
                <option value="" disabled selected>Select a plan</option>
                @foreach($plans as $plan)
                  <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="questDueDate" class="form-label">Due Date</label>
              <input type="date" class="form-control" id="questDueDate" name="due_date" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Quest</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Edit Quest Modal -->
<div class="modal fade" id="editQuestModal" tabindex="-1" aria-labelledby="editQuestModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editQuestModalLabel">Edit Quest</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editQuestForm" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label for="editQuestTitle" class="form-label">Title</label>
            <input type="text" class="form-control" id="editQuestTitle" name="title" required>
          </div>
          <div class="mb-3">
            <label for="editQuestDescription" class="form-label">Description</label>
            <textarea class="form-control" id="editQuestDescription" name="description" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="editQuestPlan" class="form-label">Plan</label>
            <select class="form-select" id="editQuestPlan" name="plan_id" required>
              @foreach($plans as $plan)
                <option value="{{ $plan->id }}">{{ $plan->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="editQuestDate" class="form-label">Due Date</label>
            <input type="date" class="form-control" id="editQuestDate" name="due_date" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

</section>

<section class="messages">
  @if (session('success'))
  <script>
      Swal.fire({
          title: 'Success!',
          text: '{{ session('success') }}',
          icon: 'success',
          timer: 3000, // 3 saniye sonra otomatik kapanır
          showConfirmButton: false
      });
  </script>
  @endif

</section>

<script>
  const editQuestModal = document.getElementById('editQuestModal');
  editQuestModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;

    // Edit butonundaki data-* değerlerini al
    const questId = button.getAttribute('data-id');
    const questTitle = button.getAttribute('data-title');
    const questDescription = button.getAttribute('data-description');
    const questPlan = button.getAttribute('data-plan');
    const questDate = button.getAttribute('data-date');

    // Modal içindeki form alanlarını doldur
    const form = editQuestModal.querySelector('form');
    form.action = `/quests/${questId}`;
    form.querySelector('#editQuestTitle').value = questTitle;
    form.querySelector('#editQuestDescription').value = questDescription;
    form.querySelector('#editQuestPlan').value = questPlan;
    form.querySelector('#editQuestDate').value = questDate;
  });

  function confirmDelete(questId) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        // Formu submit et
        document.getElementById(`delete-form-${questId}`).submit();
      }
    });
  }
</script>


@endsection
