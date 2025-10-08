# PROFESSIONALS CRUD - TODO LIST
**Sprint 2** - Extracted Tasks from trash/professionals_todo.txt  
*Generated: 2025-10-08*

## HIGH PRIORITY TASKS

### Documentation & Setup
- [ ] Create a super simple .md from this todo.txt in English
- [ ] Confirm that the login HTML was correctly implemented, including proper directory distribution

### Professional Form Implementation
- [ ] Implement the professional insertion form (if not created, if yes, review that it's up to date)
- [ ] Fix redirection after successfully adding a professional (inspire yourself with how the "Centers" form does it)
- [ ] Validate values entered in the professional form

### Professional Listing Implementation
- [ ] Implement professional listing with correct GET and POST methods using appropriate methods, inspired by "Centers"
- [ ] Implement column with edit button (objective: modify record information - implement button that should carry the entire record object as parameter, but for now should not do anything)
- [ ] Implement column with soft delete in the previous listing
- [ ] Implement filter to the professional list to show inactive ones (only inactive)

## Technical Notes
- Everything should be styled as simply as possible with Tailwind + DaisyUI
- **"Centers" context reference:** 
  - `app/Http/Controllers/CenterController.php`
  - `routes/web.php` 
  - `resources/views/components/contents/center/*`

## Progress Tracking
- [ ] Task 1: Create .md file ✅
- [ ] Task 2: Confirm login implementation
- [ ] Task 3: Review project structure
- [ ] Task 4: Implement professional form
- [ ] Task 5: Fix redirections
- [ ] Task 6: Add form validation
- [ ] Task 7: Implement professional listing
- [ ] Task 8: Add edit functionality
- [ ] Task 9: Add soft delete
- [ ] Task 10: Add inactive filter
