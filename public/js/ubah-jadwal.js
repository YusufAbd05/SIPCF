(function(){
    // ─── Constants ───
    const MN=['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const DN=['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const BASE='';
    const today=new Date();
    const todayStr=`${today.getFullYear()}-${pad(today.getMonth()+1)}-${pad(today.getDate())}`;

    // ─── State ───
    let currentBooking=null;
    let lapangsData=[];
    let rcYear=today.getFullYear(), rcMonth=today.getMonth();
    let rcSelectedDate=null;
    let rcSelectedSlot=null;
    let bookedSlotsData={};

    // ─── Helpers ───
    function pad(n){return String(n).padStart(2,'0');}
    function dateStr(y,m,d){return`${y}-${pad(m+1)}-${pad(d)}`;}
    function fmtTgl(s){const d=new Date(s+'T00:00:00');return`${DN[d.getDay()]}, ${d.getDate()} ${MN[d.getMonth()]} ${d.getFullYear()}`;}
    function fmtJam(s){return s.substring(0,5)+' WIB';}
    function fmtRp(n){return'Rp '+parseInt(n).toLocaleString('id-ID');}
    function isPastSlot(ds,h){if(ds!==todayStr)return false;return h<=today.getHours();}

    function getOpHours(lap,ds){
        const dow=new Date(ds+'T00:00:00').getDay();
        const isWE=(dow===0||dow===6);
        const jB=parseInt(isWE?lap.jam_buka_weekend:lap.jam_buka_weekday)||0;
        let jT=parseInt(isWE?lap.jam_tutup_weekend:lap.jam_tutup_weekday)||0;
        if(jT<=jB)jT=24;
        return{jamBuka:jB,jamTutup:jT,isWeekend:isWE};
    }

    // ─── API ───
    async function fetchLapangs(){
        try{const r=await fetch(`${BASE}/api/getLapangs`);lapangsData=await r.json();}
        catch(e){lapangsData=[];}
    }

    // ─── Lookup ───
    window.handleLookup=async function(e){
        e.preventDefault();
        const code=document.getElementById('inputBookingCode').value.trim().toUpperCase();
        const alertErr=document.getElementById('alertError');
        const btn=document.getElementById('btnLookup');
        alertErr.classList.add('d-none');
        btn.disabled=true;
        btn.innerHTML='<span class="spinner-border spinner-border-sm me-2"></span> Mencari...';
        try{
            const res=await fetch(`${BASE}/api/lookupBooking?kode=${encodeURIComponent(code)}`);
            const data=await res.json();
            if(data.success){
                currentBooking=data.booking;
                showBookingModal(data.booking);
            }else{
                document.getElementById('alertErrorTitle').textContent='Booking tidak dapat diubah';
                document.getElementById('alertErrorMsg').textContent=data.message;
                alertErr.classList.remove('d-none');
            }
        }catch(err){
            document.getElementById('alertErrorTitle').textContent='Terjadi kesalahan';
            document.getElementById('alertErrorMsg').textContent='Gagal menghubungi server.';
            alertErr.classList.remove('d-none');
        }finally{
            btn.disabled=false;
            btn.innerHTML='<span class="material-symbols-outlined" style="font-size:1.15rem;">search</span> Cari Booking';
        }
        return false;
    };

    // ─── Modal ───
    function showBookingModal(b){
        document.getElementById('modalKode').textContent=b.kode_sewa;
        document.getElementById('modalNama').textContent=b.nama_penyewa;
        document.getElementById('modalLapang').textContent=b.nama_lapangan;
        document.getElementById('modalTanggal').textContent=fmtTgl(b.tanggal_main);
        document.getElementById('modalJam').textContent=fmtJam(b.jam_mulai)+' - '+fmtJam(b.jam_selesai);
        document.getElementById('modalDurasi').textContent=b.durasi_jam+' Jam';
        document.getElementById('modalHarga').textContent=fmtRp(b.total_bayar);
        const pill=document.getElementById('modalStatus');
        pill.textContent=b.status_pesanan;
        const s=b.status_pesanan;
        if(s==='Dikonfirmasi'||s==='Selesai')pill.style.cssText='background:rgba(16,185,129,.15);color:#10b981;';
        else if(s.startsWith('Menunggu'))pill.style.cssText='background:rgba(245,158,11,.15);color:#f59e0b;';
        else pill.style.cssText='background:rgba(239,68,68,.15);color:#ef4444;';

        document.getElementById('btnEditBooking').onclick=function(){
            bootstrap.Modal.getInstance(document.getElementById('detailBookingModal')).hide();
            showRescheduleSection();
        };
        new bootstrap.Modal(document.getElementById('detailBookingModal')).show();
    }

    // ─── Show Reschedule Section ───
    function showRescheduleSection(){
        const b=currentBooking;
        document.getElementById('bookingLookup').classList.add('d-none');
        document.getElementById('bookingSuccess').classList.add('d-none');
        const sec=document.getElementById('rescheduleSection');
        sec.classList.remove('d-none');
        sec.style.animation='none';sec.offsetHeight;sec.style.animation='slideUp .45s cubic-bezier(.22,1,.36,1) both';

        document.getElementById('editTitle').textContent=b.nama_lapangan;
        document.getElementById('editCode').textContent=b.kode_sewa;
        document.getElementById('editStatus').textContent=b.status_pesanan;
        document.getElementById('editNama').textContent=b.nama_penyewa;
        document.getElementById('editTanggal').textContent=fmtTgl(b.tanggal_main);
        document.getElementById('editJam').textContent=fmtJam(b.jam_mulai)+' - '+fmtJam(b.jam_selesai);
        document.getElementById('editDurasi').textContent=b.durasi_jam+' Jam';

        rcSelectedDate=null;
        rcSelectedSlot=null;
        document.getElementById('rcSlotSection').style.display='none';
        document.getElementById('rcConfirmWrap').style.display='none';

        renderCalendar();
    }

    window.showLookup=function(){
        document.getElementById('rescheduleSection').classList.add('d-none');
        document.getElementById('bookingSuccess').classList.add('d-none');
        const lk=document.getElementById('bookingLookup');
        lk.classList.remove('d-none');
    };

    // ─── Calendar ───
    async function renderCalendar(){
        const calDates=document.getElementById('rcCalDates');
        const calLabel=document.getElementById('rcCalLabel');
        calLabel.textContent=`${MN[rcMonth]} ${rcYear}`;

        if(lapangsData.length===0)await fetchLapangs();

        let firstDay=new Date(rcYear,rcMonth,1).getDay();
        firstDay=(firstDay+6)%7;
        const daysInMonth=new Date(rcYear,rcMonth+1,0).getDate();

        let html='';
        for(let i=0;i<firstDay;i++)html+='<span class="cal-cell cal-cell--empty"></span>';

        for(let d=1;d<=daysInMonth;d++){
            const ds=dateStr(rcYear,rcMonth,d);
            const isToday=ds===todayStr;
            const isSel=ds===rcSelectedDate;
            const isPast=ds<todayStr;

            let cls='cal-cell';
            if(isToday)cls+=' cal-cell--today';
            if(isSel)cls+=' cal-cell--selected';
            if(isPast)cls+=' cal-cell--past';

            html+=`<span class="${cls}" data-date="${ds}" role="button" tabindex="0" ${isPast?'aria-disabled="true"':''}><span class="cal-cell__num">${d}</span></span>`;
        }
        calDates.innerHTML=html;

        calDates.querySelectorAll('.cal-cell:not(.cal-cell--empty):not(.cal-cell--past)').forEach(cell=>{
            cell.addEventListener('click',()=>selectRcDate(cell.dataset.date));
        });
    }

    document.getElementById('rcCalPrev').addEventListener('click',()=>{
        rcMonth--;if(rcMonth<0){rcMonth=11;rcYear--;}renderCalendar();
    });
    document.getElementById('rcCalNext').addEventListener('click',()=>{
        rcMonth++;if(rcMonth>11){rcMonth=0;rcYear++;}renderCalendar();
    });

    // ─── Select Date → Show Timeslots ───
    async function selectRcDate(ds){
        rcSelectedDate=ds;
        rcSelectedSlot=null;
        renderCalendar();

        const sec=document.getElementById('rcSlotSection');
        const loading=document.getElementById('rcSlotLoading');
        const card=document.getElementById('rcTimeslotCard');
        const confirmWrap=document.getElementById('rcConfirmWrap');
        const dateLabel=document.getElementById('rcDateLabel');
        const summary=document.getElementById('rcSlotSummary');
        const summaryText=document.getElementById('rcSlotSummaryText');

        sec.style.display='block';
        loading.style.display='block';
        card.innerHTML='';
        confirmWrap.style.display='none';
        document.getElementById('rcError').classList.add('d-none');

        dateLabel.innerHTML=`<span class="material-symbols-outlined" style="font-size:.95rem;vertical-align:-3px;">today</span> ${fmtTgl(ds)}`;

        // Fetch booked slots
        try{
            const res=await fetch(`${BASE}/api/getBookedSlots?tanggal=${ds}`);
            bookedSlotsData=await res.json();
        }catch(e){bookedSlotsData={};}

        loading.style.display='none';

        // Find the lapang for current booking
        const lap=lapangsData.find(l=>l.id_lapang==currentBooking.id_lapang);
        if(!lap){card.innerHTML='<p class="text-center text-muted">Lapangan tidak ditemukan.</p>';return;}

        const{jamBuka,jamTutup,isWeekend}=getOpHours(lap,ds);
        const bookedSlots=bookedSlotsData[currentBooking.id_lapang]||[];
        const durasi=parseInt(currentBooking.durasi_jam);

        // Exclude own booking hours if same date
        let ownHours=[];
        if(ds===currentBooking.tanggal_main){
            const sh=parseInt(currentBooking.jam_mulai.substring(0,2));
            for(let h=sh;h<sh+durasi;h++)ownHours.push(pad(h)+':00');
        }

        let slotsHtml='';
        let availCount=0,bookedCount=0;

        for(let h=jamBuka;h<=jamTutup-durasi;h++){
            let ok=true;
            for(let d=0;d<durasi;d++){
                const sl=pad(h+d)+':00';
                if(bookedSlots.includes(sl)&&!ownHours.includes(sl)){ok=false;break;}
            }
            if(isPastSlot(ds,h))ok=false;

            const jm=pad(h)+':00',js=pad(h+durasi)+':00';
            const label=`${pad(h)}.00 - ${pad(h+durasi)}.00`;
            let boxClass='timeslot-box';
            let icon='schedule',badge='';

            if(!ok){
                const isBooked=bookedSlots.some((sl,_)=>{const hh=parseInt(sl);return hh>=h&&hh<h+durasi;})&&!ownHours.length;
                if(isPastSlot(ds,h)){
                    boxClass+=' timeslot-box--past';icon='history';
                    badge='<span class="timeslot-badge timeslot-badge--lewat">Lewat</span>';
                }else{
                    boxClass+=' timeslot-box--booked';icon='event_busy';bookedCount++;
                    badge='<span class="timeslot-badge timeslot-badge--terisi">Terisi</span>';
                }
            }else{
                boxClass+=' timeslot-box--available';availCount++;
                badge='<span class="timeslot-badge timeslot-badge--kosong">Kosong</span>';
            }

            slotsHtml+=`<div class="${boxClass}" data-jam="${jm}" data-jam-selesai="${js}" tabindex="${ok?'0':''}" style="animation-delay:${0.03*(h-jamBuka)}s">
                <span class="material-symbols-outlined timeslot-box__icon">${icon}</span>
                <span class="timeslot-box__label">${label}</span>
                ${badge}
            </div>`;
        }

        const jamLabel=isWeekend?'Weekend':'Weekday';
        card.innerHTML=`<div class="lapang-card" style="animation:slideUp .5s cubic-bezier(.22,1,.36,1) both;">
            <div class="lapang-card__header">
                <span class="material-symbols-outlined lapang-card__icon">stadium</span>
                <div>
                    <span class="lapang-card__title">${lap.nama_lapangan}</span>
                    <div class="lapang-card__subtitle">${jamLabel} · ${pad(jamBuka)}.00 - ${pad(jamTutup)}.00 · Durasi ${durasi} Jam</div>
                </div>
            </div>
            <div class="lapang-card__stats">
                <span class="lapang-card__stat stat--available"><span class="material-symbols-outlined">check_circle</span> ${availCount} tersedia</span>
                <span class="lapang-card__stat stat--booked"><span class="material-symbols-outlined">block</span> ${bookedCount} terisi</span>
            </div>
            <div class="lapang-card__body"><div class="timeslot-grid">${slotsHtml}</div></div>
        </div>`;

        summary.style.display='flex';
        summaryText.textContent=`${availCount} slot tersedia · ${bookedCount} terisi`;

        // Attach slot click handlers
        card.querySelectorAll('.timeslot-box--available').forEach(box=>{
            box.addEventListener('click',function(){
                card.querySelectorAll('.timeslot-box--selected').forEach(s=>{if(s!==box)s.classList.remove('timeslot-box--selected');});
                box.classList.toggle('timeslot-box--selected');
                const sel=card.querySelector('.timeslot-box--selected');
                if(sel){
                    rcSelectedSlot={jam_mulai:sel.dataset.jam,jam_selesai:sel.dataset.jamSelesai};
                    confirmWrap.style.display='block';
                    confirmWrap.style.animation='slideUp .35s cubic-bezier(.22,1,.36,1) both';
                }else{
                    rcSelectedSlot=null;
                    confirmWrap.style.display='none';
                }
            });
        });

        setTimeout(()=>{sec.scrollIntoView({behavior:'smooth',block:'start'});},100);
    }

    // ─── Confirm Reschedule ───
    window.confirmReschedule=async function(){
        if(!rcSelectedDate||!rcSelectedSlot||!currentBooking){alert('Pilih tanggal dan jam baru.');return;}
        if(rcSelectedDate===currentBooking.tanggal_main&&rcSelectedSlot.jam_mulai===currentBooking.jam_mulai.substring(0,5)){
            alert('Jadwal baru sama dengan jadwal saat ini.');return;
        }
        const btn=document.getElementById('btnConfirm');
        const errDiv=document.getElementById('rcError');
        errDiv.classList.add('d-none');
        btn.disabled=true;btn.innerHTML='<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
        try{
            const fd=new FormData();
            fd.append('kode_sewa',currentBooking.kode_sewa);
            fd.append('tanggal_baru',rcSelectedDate);
            fd.append('jam_mulai_baru',rcSelectedSlot.jam_mulai);
            const res=await fetch(`${BASE}/api/ubahJadwal`,{method:'POST',body:fd});
            const data=await res.json();
            if(data.success){
                document.getElementById('rescheduleSection').classList.add('d-none');
                document.getElementById('successDate').textContent=fmtTgl(data.data.tanggal_baru);
                document.getElementById('successTime').textContent=fmtJam(data.data.jam_mulai)+' - '+fmtJam(data.data.jam_selesai);
                const sc=document.getElementById('bookingSuccess');sc.classList.remove('d-none');
                sc.style.animation='slideUp .45s cubic-bezier(.22,1,.36,1) both';
                window.scrollTo({top:0,behavior:'smooth'});
            }else{
                document.getElementById('rcErrorMsg').textContent=data.message;
                errDiv.classList.remove('d-none');
            }
        }catch(err){
            document.getElementById('rcErrorMsg').textContent='Gagal menghubungi server.';
            errDiv.classList.remove('d-none');
        }finally{
            btn.disabled=false;btn.innerHTML='<span class="material-symbols-outlined" style="font-size:1.15rem;">check_circle</span> Konfirmasi Perubahan Jadwal';
        }
    };

    // ─── Init: pre-fetch lapangs ───
    fetchLapangs();
})();
