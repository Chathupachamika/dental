
<style>
    .btn-gray {
        background: linear-gradient(135deg, #888888, #4B4B4B);
    }

    .btn-gray:hover {
        background: linear-gradient(135deg, #686868, #333333);
    }
    .btn-red {
        background: linear-gradient(135deg, #EA2F2F, #5E1313);
        transition: all 0.3s ease;
    }

    .btn-red:hover {
        background: linear-gradient(135deg, #fc1010, #380606);
    }
</style>

<div id="rateModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
    <div class="bg-gray-800 p-6 rounded-lg w-96">
        <h2 class="text-xl font-bold mb-4">Rate Your Experience</h2>
        <div class="space-y-4">
            <div class="flex justify-center space-x-2">
                <i onclick="rateChange('1')" class="fas fa-star text-2xl cursor-pointer text-gray-400 hover:text-yellow-400"></i>
                <i onclick="rateChange('2')" class="fas fa-star text-2xl cursor-pointer text-gray-400 hover:text-yellow-400"></i>
                <i onclick="rateChange('3')" class="fas fa-star text-2xl cursor-pointer text-gray-400 hover:text-yellow-400"></i>
                <i onclick="rateChange('4')" class="fas fa-star text-2xl cursor-pointer text-gray-400 hover:text-yellow-400"></i>
                <i onclick="rateChange('5')" class="fas fa-star text-2xl cursor-pointer text-gray-400 hover:text-yellow-400"></i>
            </div>
            <form  method="POST" action="{{ route('rate.store') }}">
                @csrf
                <input style="display: none;" id="rate_count" name="rate_count" type="text">
            <textarea name="rate_experience" class="w-full bg-gray-700 rounded-md p-2 h-32" placeholder="Share your experience..."></textarea>
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeRateModal()" class="btn-gray px-4 py-2 rounded">Cancel</button>
                <button type="submit" onclick="submitRating()" class="btn-red px-4 py-2 rounded">Submit</button>
              
            </div>
            </form>
        </div>
    </div>
</div>


<script>

  function showRateModal() {
    const modal = document.getElementById('rateModal');
    modal.classList.remove('hidden'); // Show modal
    modal.classList.add('flex'); // Ensure flex for centering
    document.querySelector('.rate-us-link')?.classList.add('rate-us-active');
}

function closeRateModal() {
    const modal = document.getElementById('rateModal');
    modal.classList.remove('flex'); // Remove flex before hiding
    modal.classList.add('hidden'); // Hide modal
    document.querySelector('.rate-us-link')?.classList.remove('rate-us-active');
}


    function rateChange(rate){
        console.log(rate);
        document.getElementById("rate_count").value=rate;
        console.log(document.getElementById("rate_count").value);
    }
    function submitRating(event) {
        closeRateModal();
        Swal.fire({
            title: 'Thank You!',
            text: 'Your rating has been submitted successfully.',
            icon: 'success',
            confirmButtonColor: '#EF4444'
        });
    }
    function getRate(){
        return "55";
    }

    // Star Rating
    document.querySelectorAll('.fa-star').forEach((star, index) => {
        star.addEventListener('click', () => {
            document.querySelectorAll('.fa-star').forEach((s, i) => {
                if (i <= index) {
                    s.classList.remove('text-gray-400');
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.add('text-gray-400');
                    s.classList.remove('text-yellow-400');
                }
            });
        });
    });
</script>