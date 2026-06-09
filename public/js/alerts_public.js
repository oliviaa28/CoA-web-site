document.addEventListener('DOMContentLoaded', function() {
    incarcaAlertePublice();
});

function incarcaAlertePublice() {
    fetch('index.php?route=api/alerts')
        .then(r => r.json())
        .then(alerts => {
            const list = document.getElementById('alerts-list');

            if (alerts.error || alerts.length === 0) {
                list.innerHTML = '<p style="text-align: center; color: var(--text-muted); padding: 2rem;">Nu există alerte active momentan.</p>';
                return;
            }

            alerts.forEach(function(al) {
                const sev = al.severity ? al.severity.toLowerCase() : '';
                let borderClass = 'border-teal';
                
                if (sev === 'extrem') { borderClass = 'border-red'; }
                else if (sev === 'sever') { borderClass = 'border-orange'; }

                let eventLinkHTML = '';
                if (al.incidentid && al.type) {
                    eventLinkHTML = `<div style="margin-top: 15px; border-top: 1px solid var(--border-color); padding-top: 10px;">
                        <a href="index.php?route=details-public&id=${al.incidentid}&type=${al.type}" class="btn-link" style="font-weight: 600;">Vezi evenimentul &rarr;</a>
                    </div>`;
                }

                list.innerHTML += `
                    <div class="card ${borderClass}" style="margin-bottom: 1rem; background-color: var(--bg-card); box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                        <h3 style="margin-bottom: 0.5rem; color: var(--text-main); font-size: 1.25rem;">${al.headline}</h3>
                        <p class="location" style="margin-bottom: 0.3rem;"><strong>📍 Zona vizată:</strong> ${al.zone}</p>
                        <p class="time" style="color: var(--text-muted); font-size: 0.9rem;">🕒 <strong>Trimis la:</strong> ${al.sentAt}</p>
                        ${eventLinkHTML}
                    </div>
                `;
            });
        })
        .catch(() => {
            document.getElementById('alerts-list').innerHTML = '<p style="text-align: center; color: red;">Nu s-au putut încărca alertele. Verificați conexiunea.</p>';
        });
}