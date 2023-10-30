<label for="semester_aktif">Semester Aktif</label>
                <select name="semester_aktif" id="semester_aktif" class="form-control">
                    @for ($i = 1; $i <= 14; $i++) 
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>