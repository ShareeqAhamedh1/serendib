<footer style="text-align:center; margin-top:30px; padding:10px; color:#888;">
  © <?= date('Y') ?> School ERP. All Rights Reserved.
</footer>
</main>

<script src="<?= BASE_URL ?>assets/js/app.js"></script>

<script>
  // Sidebar dropdown toggle
  document.querySelectorAll(".dropdown-btn").forEach(btn => {
    btn.addEventListener("click", () => {
      const dropdown = btn.nextElementSibling;
      dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    });
  });

  // Hide flash messages automatically
  const msg = document.getElementById('msgBox');
  if (msg) setTimeout(() => msg.remove(), 2500);

  // Class-section linking (if present)
  const classSelect = document.getElementById('classSelect');
  if (classSelect) {
    classSelect.addEventListener('change', function() {
      const classId = this.value;
      const sectionSelect = document.getElementById('sectionSelect');
      sectionSelect.innerHTML = '<option value="">Loading...</option>';

      if (!classId) {
        sectionSelect.innerHTML = '<option value="">-- Select Section --</option>';
        return;
      }

      fetch('<?= BASE_URL ?>backend/get_sections.php?class_id=' + classId)
        .then(res => res.json())
        .then(data => {
          sectionSelect.innerHTML = '<option value="">-- Select Section --</option>';
          data.forEach(sec => {
            sectionSelect.innerHTML += `<option value="${sec.id}">${sec.section_name}</option>`;
          });
        })
        .catch(err => {
          console.error('Error fetching sections:', err);
          sectionSelect.innerHTML = '<option value="">Error loading</option>';
        });
    });
  }
</script>

</body>
</html>
