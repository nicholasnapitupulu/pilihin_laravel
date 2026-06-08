<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tes Minat - PILIH.in</title>
    <link href="{{ asset('src/output.css') }}" rel="stylesheet">
</head>
<body class="bg-base font-sans text-slate-800">
    
    @include('components.navbar')

    <main class="pt-32 pb-20 container mx-auto px-4 lg:px-12">
        <div class="max-w-3xl mx-auto bg-white rounded-3xl p-8 shadow-sm border border-slate-100">
            
            <div class="mb-8">
                <div class="flex justify-between text-sm font-semibold mb-2">
                    <span class="text-primary">Progress Tes</span>
                    <span id="progressText">0%</span>
                </div>
                <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                    <div id="progressBar" class="bg-primary h-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>

            <form id="quizForm" action="{{ route('tes.proses') }}" method="POST">
                @csrf {{-- Token keamanan wajib di Laravel untuk form POST --}}
                
                <div id="hiddenAnswersContainer"></div>
                <div id="questionContainer" class="min-h-[250px]"></div>

                <div class="flex justify-between items-center mt-10 pt-6 border-t border-slate-100">
                    <button type="button" id="prevBtn" onclick="changeQuestion(-1)" class="hidden px-6 py-3 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition">
                        Kembali
                    </button>
                    <button type="button" id="nextBtn" onclick="changeQuestion(1)" class="ml-auto px-8 py-3 bg-primary text-white rounded-2xl font-bold hover:bg-primary/90 transition shadow-lg shadow-primary/20">
                        Lanjut
                    </button>
                    <button type="submit" id="submitBtn" class="hidden ml-auto px-8 py-3 bg-green-500 text-white rounded-2xl font-bold hover:bg-green-600 transition shadow-lg shadow-green-200">
                        Selesai dan Lihat Hasil
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Mengubah data dari Laravel Controller menjadi Array JSON di JavaScript
        const questions = @json($questions);
        let currentStep = 0;
        const totalSteps = questions.length;
        const answers = {};

        function renderQuestion() {
            if (totalSteps === 0) return;
            
            const q = questions[currentStep];
            const container = document.getElementById('questionContainer');
            
            container.style.opacity = 0;
            
            setTimeout(() => {
                container.innerHTML = `
                    <div class="animate-fadeIn">
                        <span class="text-primary font-bold text-sm uppercase tracking-wider">Pertanyaan ${currentStep + 1} dari ${totalSteps}</span>
                        <h2 class="text-2xl font-bold text-slate-800 mt-2 mb-6">${q.teks_pertanyaan}</h2>
                        <div class="grid grid-cols-1 gap-3">
                            ${[1,2,3,4,5].map(score => `
                                <label class="flex items-center cursor-pointer rounded-2xl border-2 p-4 transition ${answers[q.id_soal] == score ? 'border-primary bg-primary/5' : 'border-slate-100 hover:border-slate-200'}">
                                    <input type="radio" name="temp_jawaban[${q.id_soal}]" value="${score}" 
                                        class="w-5 h-5 text-primary focus:ring-primary" 
                                        ${answers[q.id_soal] == score ? 'checked' : ''} 
                                        onchange="saveAnswer(${q.id_soal}, ${score})">
                                    <span class="ml-4 font-medium text-slate-700">${getScoreLabel(score)}</span>
                                </label>
                            `).join('')}
                        </div>
                    </div>
                `;
                container.style.opacity = 1;
            }, 150);

            updateUI();
        }

        function getScoreLabel(score) {
            const labels = {
                1: "Sangat Tidak Tertarik",
                2: "Tidak Tertarik",
                3: "Ragu-ragu / Netral",
                4: "Tertarik",
                5: "Sangat Tertarik"
            };
            return labels[score];
        }

        function saveAnswer(id, score) {
            answers[id] = score;

            const hiddenContainer = document.getElementById('hiddenAnswersContainer');
            let existingInput = document.querySelector(`input[name="jawaban[${id}]"]`);
            
            if (existingInput) {
                existingInput.value = score;
            } else {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `jawaban[${id}]`;
                input.value = score;
                hiddenContainer.appendChild(input);
            }

            renderQuestion();

            if (currentStep < totalSteps - 1) {
                setTimeout(() => {
                    currentStep++;
                    renderQuestion();
                }, 300);
            }
        }

        function changeQuestion(n) {
            if (n === 1 && !answers[questions[currentStep].id_soal]) {
                alert("Silakan pilih jawaban terlebih dahulu!");
                return;
            }

            currentStep += n;
            renderQuestion();
        }

        function updateUI() {
            if (totalSteps === 0) return;

            const progress = ((currentStep + 1) / totalSteps) * 100;
            document.getElementById('progressBar').style.width = `${progress}%`;
            document.getElementById('progressText').innerText = `${Math.round(progress)}%`;

            document.getElementById('prevBtn').classList.toggle('hidden', currentStep === 0);
            
            if (currentStep === totalSteps - 1) {
                document.getElementById('nextBtn').classList.add('hidden');
                document.getElementById('submitBtn').classList.remove('hidden');
            } else {
                document.getElementById('nextBtn').classList.remove('hidden');
                document.getElementById('submitBtn').classList.add('hidden');
            }
        }

        renderQuestion();
    </script>

    <style>
        .animate-fadeIn { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        #questionContainer { transition: opacity 0.2s ease; }
    </style>

    @include('components.footer')
</body>
</html>