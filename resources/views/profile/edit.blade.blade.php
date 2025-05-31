            </div>
        </div>

        {{-- Riwayat Peminjaman Terbaru only for users --}}
        @if(Auth::check() && Auth::user()->role === 'user')
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Riwayat Peminjaman Terbaru</h5>
            </div>
            <div class="card-body">
// ... existing code ...
                    </div>
                @endif
            </div>
        </div>
        @endif {{-- End if user role check --}}

    </div>
</div>
@endsection 