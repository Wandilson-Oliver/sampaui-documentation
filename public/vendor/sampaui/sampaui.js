(() => {
const focusableSelector = [
  'a[href]',
  'button:not([disabled])',
  'input:not([disabled]):not([type="hidden"])',
  'select:not([disabled])',
  'textarea:not([disabled])',
  '[tabindex]:not([tabindex="-1"])',
].join(',');

const focusableElements = (element) => Array.from(element?.querySelectorAll(focusableSelector) ?? [])
  .filter((item) => !item.hasAttribute('hidden') && item.getClientRects().length > 0);

const syncControl = (control) => {
  if (!control) return;
  control.dispatchEvent(new Event('input', { bubbles: true }));
  control.dispatchEvent(new Event('change', { bubbles: true }));
};

const lockPageScroll = () => {
  if (typeof window === 'undefined') return;
  window.SampaUIOverlayLockCount = Math.max(Number(window.SampaUIOverlayLockCount ?? 0), 0) + 1;
  document.documentElement.classList.add('overflow-hidden');
  document.body.classList.add('overflow-hidden');
};

const unlockPageScroll = () => {
  if (typeof window === 'undefined') return;
  window.SampaUIOverlayLockCount = Math.max(Number(window.SampaUIOverlayLockCount ?? 0) - 1, 0);
  if (window.SampaUIOverlayLockCount > 0) return;
  document.documentElement.classList.remove('overflow-hidden');
  document.body.classList.remove('overflow-hidden');
};

const portalMenu = (config = {}) => ({
  menuStyle: {},
  viewportHandler: null,
  initPortalMenu() {
    this.viewportHandler = () => this.positionMenu();
    window.addEventListener('resize', this.viewportHandler);
    window.addEventListener('scroll', this.viewportHandler, true);
  },
  destroyPortalMenu() {
    window.removeEventListener('resize', this.viewportHandler);
    window.removeEventListener('scroll', this.viewportHandler, true);
  },
  triggerElement() {
    return document.getElementById(config.triggerId);
  },
  menuElement() {
    return document.getElementById(config.menuId);
  },
  positionMenu() {
    const triggerElement = this.triggerElement();
    const menu = this.menuElement();
    const isOpen = Boolean(this.open || this.showTooltip);
    if (!isOpen || !triggerElement || !menu) return;
    const trigger = triggerElement.getBoundingClientRect();
    const gap = Number(config.gap ?? 8);
    const viewportPadding = Number(config.viewportPadding ?? 12);
    const placement = config.placement ?? 'bottom';
    const align = config.align ?? 'left';

    const isTooltip = Boolean(config.isTooltip || this.showTooltip);
    const rect = menu.getBoundingClientRect();
    const naturalWidth = rect.width || menu.offsetWidth || menu.scrollWidth || trigger.width;
    const preferredWidth = config.matchTriggerWidth === false
      ? naturalWidth
      : Math.max(trigger.width, Number(config.minWidth ?? 0));
    const menuWidth = Math.min(
      preferredWidth,
      window.innerWidth - (viewportPadding * 2),
    );

    const naturalHeight = rect.height || menu.offsetHeight || menu.scrollHeight || (isTooltip ? 28 : 288);
    const preferredHeight = Number(config.preferredHeight ?? (isTooltip ? naturalHeight + gap : 240));
    const below = window.innerHeight - trigger.bottom - viewportPadding;
    const above = trigger.top - viewportPadding;

    let opensUp = placement === 'top';
    if (placement === 'top' || placement === 'bottom') {
      if (placement === 'bottom' && below < (isTooltip ? naturalHeight + gap : preferredHeight) && above > below) opensUp = true;
      if (placement === 'top' && above < (isTooltip ? naturalHeight + gap : preferredHeight) && below > above) opensUp = false;
    }

    const availableHeight = Math.max(isTooltip ? 28 : 120, (opensUp ? above : below) - gap);
    const menuHeight = isTooltip ? naturalHeight : Math.min(naturalHeight, availableHeight);

    let left = trigger.left;
    let top = trigger.bottom + gap;

    if (placement === 'left' || placement === 'right') {
      let opensRight = placement === 'right';
      const rightSpace = window.innerWidth - trigger.right - viewportPadding;
      const leftSpace = trigger.left - viewportPadding;
      if (opensRight && rightSpace < menuWidth && leftSpace > rightSpace) opensRight = false;
      if (!opensRight && leftSpace < menuWidth && rightSpace > leftSpace) opensRight = true;

      left = opensRight ? trigger.right + gap : trigger.left - menuWidth - gap;
      top = trigger.top + (trigger.height / 2) - (menuHeight / 2);
    } else {
      top = opensUp ? trigger.top - menuHeight - gap : trigger.bottom + gap;
      if (align === 'right') {
        left = trigger.right - menuWidth;
      } else if (align === 'center') {
        left = trigger.left + (trigger.width / 2) - (menuWidth / 2);
      } else {
        left = trigger.left;
      }
    }

    left = Math.max(viewportPadding, Math.min(left, window.innerWidth - menuWidth - viewportPadding));
    top = Math.max(viewportPadding, Math.min(top, window.innerHeight - menuHeight - viewportPadding));

    const activeOverlay = document.querySelector('[data-sampaui-overlay-active="true"]');
    const overlay = triggerElement.closest('[data-sampaui-overlay]') || activeOverlay;
    const overlayLayer = Number.parseInt(overlay ? window.getComputedStyle(overlay).zIndex : '', 10);

    this.menuStyle = {
      position: 'fixed',
      left: `${left}px`,
      top: `${top}px`,
      ...(isTooltip ? {} : { width: `${menuWidth}px`, maxHeight: `${availableHeight}px` }),
      zIndex: Number.isFinite(overlayLayer) ? overlayLayer + 20 : 120,
    };
  },
  handleMenuOutside(event) {
    const isOpen = Boolean(this.open || this.showTooltip);
    if (!isOpen) return;
    if (this.$root.contains(event.target) || this.menuElement()?.contains(event.target)) return;
    if (typeof this.close === 'function') this.close();
    else if (typeof this.hide === 'function') this.hide();
  },
});

const SampaUI = {
  version: '0.1.28',

  input({ clearable = false } = {}) {
    return {
      clearable,
      showPassword: false,
      hasValue: false,
      init() {
        this.hasValue = Boolean(this.$refs.control?.value);
        this.$refs.control?.addEventListener('input', () => this.updateValueState());
      },
      updateValueState() {
        this.hasValue = Boolean(this.$refs.control?.value);
      },
      clear() {
        if (!this.clearable || !this.$refs.control) return;
        this.$refs.control.value = '';
        if (this.$refs.control._x_model) this.$refs.control._x_model.set('');
        syncControl(this.$refs.control);
        this.updateValueState();
        this.$refs.control.focus();
      },
    };
  },

  phone() {
    return {
      format(value) {
        const digits = String(value ?? '').replace(/\D/g, '').slice(0, 11);
        if (digits.length <= 2) return digits;
        if (digits.length <= 6) return `(${digits.slice(0, 2)}) ${digits.slice(2)}`;
        if (digits.length <= 10) return `(${digits.slice(0, 2)}) ${digits.slice(2, 6)}-${digits.slice(6)}`;
        return `(${digits.slice(0, 2)}) ${digits.slice(2, 3)} ${digits.slice(3, 7)}-${digits.slice(7)}`;
      },
      onInput(event) {
        event.target.value = this.format(event.target.value);
        if (event.target._x_model) event.target._x_model.set(event.target.value);
      },
    };
  },

  avatarUpload({ existing = null } = {}) {
    return {
      preview: null,
      removed: false,
      existing,
      get currentSrc() {
        return this.removed ? null : (this.preview || this.existing);
      },
      selectFile(event) {
        const [file] = Array.from(event.target.files || []).filter((item) => item.type.startsWith('image/'));
        if (!file) return;
        if (this.preview) URL.revokeObjectURL(this.preview);
        this.removed = false;
        this.preview = URL.createObjectURL(file);
        this.syncRemoveInput();
      },
      removeImage() {
        this.removed = true;
        if (this.preview) URL.revokeObjectURL(this.preview);
        this.preview = null;
        this.$refs.input.value = '';
        syncControl(this.$refs.input);
        this.syncRemoveInput();
      },
      syncRemoveInput() {
        this.$nextTick(() => {
          if (!this.$refs.removeInput) return;
          this.$refs.removeInput.value = this.removed ? '1' : '0';
          syncControl(this.$refs.removeInput);
        });
      },
    };
  },

  select(config = {}) {
    return {
      ...portalMenu(config),
      open: false,
      value: String(config.value ?? ''),
      selectedLabel: config.selectedLabel ?? '',
      options: config.options ?? [],
      placeholder: config.placeholder ?? '',
      disabled: Boolean(config.disabled),
      readonly: Boolean(config.readonly),
      activeIndex: -1,
      init() {
        this.initPortalMenu();
        if (!this.value && this.$refs.native?.value) this.value = String(this.$refs.native.value);
        if (this.options.length === 0 && this.$refs.native) {
          this.options = Array.from(this.$refs.native.options)
            .filter((option) => option.value !== '')
            .map((option) => ({ value: String(option.value), label: option.textContent.trim(), disabled: option.disabled }));
        }
        this.syncSelectedLabel();
        this.$watch('value', () => this.syncSelectedLabel());
      },
      canInteract() {
        return !this.disabled && !this.readonly;
      },
      syncSelectedLabel() {
        this.selectedLabel = this.options.find((option) => option.value === String(this.value))?.label || '';
      },
      openMenu() {
        if (!this.canInteract()) return;
        this.open = true;
        const selectedIndex = this.options.findIndex((option) => option.value === String(this.value) && !option.disabled);
        this.activeIndex = selectedIndex >= 0 ? selectedIndex : this.options.findIndex((option) => !option.disabled);
        this.scrollActive();
        this.$nextTick(() => this.positionMenu());
      },
      close() {
        this.open = false;
        this.activeIndex = -1;
      },
      toggle() {
        this.open ? this.close() : this.openMenu();
      },
      move(step) {
        if (!this.open) this.openMenu();
        if (!this.options.length) return;
        let next = this.activeIndex;
        for (let attempts = 0; attempts < this.options.length; attempts += 1) {
          next = (next + step + this.options.length) % this.options.length;
          if (!this.options[next]?.disabled) { this.activeIndex = next; break; }
        }
        this.scrollActive();
      },
      moveTo(edge) {
        if (!this.open) this.openMenu();
        let index = -1;
        if (edge === 'end') {
          for (let cursor = this.options.length - 1; cursor >= 0; cursor -= 1) {
            if (!this.options[cursor].disabled) { index = cursor; break; }
          }
        } else index = this.options.findIndex((option) => !option.disabled);
        if (index >= 0) { this.activeIndex = index; this.scrollActive(); }
      },
      scrollActive() {
        this.$nextTick(() => document.getElementById(`${config.id}-option-${this.activeIndex}`)?.scrollIntoView({ block: 'nearest' }));
      },
      chooseActive() {
        if (this.open && this.options[this.activeIndex]) this.select(this.options[this.activeIndex]);
        else this.openMenu();
      },
      select(option) {
        if (!this.canInteract() || option.disabled) return;
        this.value = String(option.value);
        this.close();
        this.commit(option);
      },
      clear() {
        if (!this.canInteract()) return;
        this.value = '';
        this.selectedLabel = '';
        this.commit({ value: '', label: '' });
      },
      commit(option) {
        this.$nextTick(() => {
          this.$refs.native.value = this.value;
          syncControl(this.$refs.native);
          this.$dispatch('select:changed', { id: config.id, name: config.name, value: this.value, label: option.label });
        });
      },
      destroy() {
        this.destroyPortalMenu();
      },
    };
  },

  selectMultiple(config = {}) {
    return {
      ...portalMenu(config),
      open: false,
      search: '',
      values: config.values ?? [],
      options: config.options ?? [],
      disabled: Boolean(config.disabled),
      readonly: Boolean(config.readonly),
      loading: Boolean(config.loading),
      activeIndex: -1,
      init() {
        this.values = this.normalize(this.values);
        this.initPortalMenu();
      },
      normalize(value) {
        if (Array.isArray(value)) return [...new Set(value.map((item) => String(item)))];
        return value === null || value === undefined || value === '' ? [] : [String(value)];
      },
      canInteract() {
        return !this.disabled && !this.readonly && !this.loading;
      },
      selectedOptions() {
        return this.values.map((value) => this.options.find((option) => String(option.value) === String(value))).filter(Boolean);
      },
      filteredOptions() {
        const term = this.search.trim().toLocaleLowerCase();
        return this.options.filter((option) => !this.values.includes(String(option.value)))
          .filter((option) => !term || option.label.toLocaleLowerCase().includes(term));
      },
      toggle() {
        if (!this.canInteract()) return;
        this.open = !this.open;
        if (this.open) this.$nextTick(() => { this.positionMenu(); document.getElementById(config.searchId)?.focus(); });
      },
      close() {
        this.open = false;
        this.search = '';
        this.activeIndex = -1;
      },
      move(step) {
        const options = this.filteredOptions();
        if (!options.length) return;
        let next = this.activeIndex;
        for (let attempts = 0; attempts < options.length; attempts += 1) {
          next = (next + step + options.length) % options.length;
          if (!options[next]?.disabled) { this.activeIndex = next; break; }
        }
        this.$nextTick(() => document.getElementById(`${config.id}-option-${this.activeIndex}`)?.scrollIntoView({ block: 'nearest' }));
      },
      chooseActive() {
        const option = this.filteredOptions()[this.activeIndex];
        if (option) this.select(option);
      },
      select(option) {
        if (!this.canInteract() || option.disabled || this.values.includes(String(option.value))) return;
        this.values = this.normalize([...this.values, option.value]);
        this.search = '';
        this.activeIndex = -1;
        this.dispatchChange(option, 'selected');
      },
      remove(value) {
        if (!this.canInteract()) return;
        const option = this.options.find((item) => String(item.value) === String(value)) || { value, label: value };
        this.values = this.values.filter((item) => String(item) !== String(value));
        this.dispatchChange(option, 'removed');
      },
      clear() {
        if (!this.canInteract()) return;
        this.values = [];
        this.dispatchChange(null, 'cleared');
      },
      dispatchChange(option, action) {
        this.$nextTick(() => {
          if (this.$refs.native) {
            Array.from(this.$refs.native.options).forEach((item) => { item.selected = this.values.includes(String(item.value)); });
            syncControl(this.$refs.native);
          }
          this.$dispatch('select-multiple:changed', { id: config.id, name: config.name, values: this.values, option, action });
        });
      },
      destroy() {
        this.destroyPortalMenu();
      },
    };
  },

  selectSearch(config = {}) {
    return {
      ...portalMenu(config),
      open: false,
      search: '',
      value: String(config.value ?? ''),
      selectedLabel: config.selectedLabel ?? '',
      options: config.options ?? [],
      placeholder: config.placeholder ?? '',
      disabled: Boolean(config.disabled),
      activeIndex: -1,
      init() {
        this.initPortalMenu();
        this.syncSelectedLabel();
        this.$watch('value', () => this.syncSelectedLabel());
      },
      canInteract() { return !this.disabled; },
      syncSelectedLabel() { this.selectedLabel = this.options.find((option) => String(option.value) === String(this.value))?.label || ''; },
      filteredOptions() {
        const term = this.search.trim().toLocaleLowerCase();
        return this.options.filter((option) => !term || option.label.toLocaleLowerCase().includes(term));
      },
      openMenu() {
        if (!this.canInteract()) return;
        this.open = true;
        this.activeIndex = this.filteredOptions().findIndex((option) => String(option.value) === String(this.value));
        this.$nextTick(() => { this.positionMenu(); document.getElementById(config.searchId)?.focus(); });
      },
      close() { this.open = false; this.search = ''; this.activeIndex = -1; },
      toggle() { this.open ? this.close() : this.openMenu(); },
      move(step) {
        const options = this.filteredOptions();
        if (!options.length) return;
        this.activeIndex = (this.activeIndex + step + options.length) % options.length;
      },
      chooseActive() {
        const option = this.filteredOptions()[this.activeIndex];
        if (option) this.select(option);
      },
      select(option) {
        if (!this.canInteract()) return;
        this.value = String(option.value);
        this.close();
        this.$nextTick(() => {
          syncControl(this.$refs.input);
          this.$dispatch('select-search:changed', { id: config.id, name: config.name, value: option.value, label: option.label });
        });
      },
      destroy() { this.destroyPortalMenu(); },
    };
  },

  fileUpload(config = {}) {
    return {
      files: [],
      error: '',
      accept: config.accept ?? '',
      maxSize: Number(config.maxSize ?? 0),
      model: config.model ?? null,
      retry: Boolean(config.retry),
      chunkSize: Number(config.chunkSize ?? 0),
      init() {
        this.$root.addEventListener('livewire-upload-start', () => this.setStatus('uploading'));
        this.$root.addEventListener('livewire-upload-progress', (event) => this.setProgress(event.detail.progress));
        this.$root.addEventListener('livewire-upload-error', () => this.setStatus('error'));
        this.$root.addEventListener('livewire-upload-finish', () => { this.setProgress(100); this.setStatus('complete'); });
      },
      accepts(file) {
        if (!this.accept) return true;
        return this.accept.split(',').map((item) => item.trim()).some((rule) => {
          if (rule.endsWith('/*')) return file.type.startsWith(rule.slice(0, -1));
          if (rule.startsWith('.')) return file.name.toLocaleLowerCase().endsWith(rule.toLocaleLowerCase());
          return file.type === rule;
        });
      },
      setFiles(input) {
        this.revokePreviewUrls();
        this.error = '';
        const incoming = Array.from(input.files || []);
        const valid = incoming.filter((file) => {
          if (!this.accepts(file)) { this.error = config.typeError; return false; }
          if (this.maxSize > 0 && file.size > this.maxSize * 1024) { this.error = config.sizeError; return false; }
          return true;
        });
        if (valid.length !== incoming.length) {
          const transfer = new DataTransfer();
          valid.forEach((file) => transfer.items.add(file));
          input.files = transfer.files;
          syncControl(input);
        }
        this.files = valid.map((file, index) => ({ file, id: `${file.name}-${file.lastModified}-${index}`, name: file.name, size: file.size, url: file.type.startsWith('image/') ? URL.createObjectURL(file) : null, progress: 0, status: 'ready' }));
        if (this.chunkSize > 0) {
          this.$dispatch('file-upload:chunks-ready', {
            model: this.model,
            chunkSize: this.chunkSize,
            files: this.files.map((item) => ({ name: item.name, chunks: Math.ceil(item.size / this.chunkSize) })),
          });
        }
      },
      removeFile(index) {
        const [removed] = this.files.splice(index, 1);
        if (removed?.url) URL.revokeObjectURL(removed.url);
        const transfer = new DataTransfer();
        this.files.forEach((item) => transfer.items.add(item.file));
        this.$refs.input.files = transfer.files;
        syncControl(this.$refs.input);
      },
      setProgress(progress) {
        this.files.forEach((file) => { if (file.status !== 'complete') file.progress = Number(progress); });
      },
      setStatus(status) {
        this.files.forEach((file) => { file.status = status; });
      },
      cancel() {
        if (this.model && this.$wire?.cancelUpload) this.$wire.cancelUpload(this.model);
        this.setStatus('cancelled');
        this.$dispatch('file-upload:cancelled', { model: this.model });
      },
      retryUpload() {
        if (!this.retry) return;
        this.setProgress(0);
        this.setStatus('ready');
        this.$dispatch('file-upload:retry', { model: this.model, files: this.files.map((item) => item.file) });
        syncControl(this.$refs.input);
      },
      revokePreviewUrls() {
        this.files.forEach((file) => { if (file.url) URL.revokeObjectURL(file.url); });
      },
      destroy() {
        this.revokePreviewUrls();
      },
    };
  },

  chatComposer({ autoResize = true, submitOnEnter = true, maxHeight = 160 } = {}) {
    return {
      autoResize: Boolean(autoResize),
      submitOnEnter: Boolean(submitOnEnter),
      maxHeight: Math.max(Number(maxHeight) || 160, 88),
      valueLength: 0,
      init() {
        this.$nextTick(() => {
          this.valueLength = this.$refs.control?.value.length ?? 0;
          this.resize();
        });
      },
      resize() {
        if (!this.autoResize || !this.$refs.control) return;
        this.valueLength = this.$refs.control.value.length;
        this.$refs.control.style.height = 'auto';
        this.$refs.control.style.height = `${Math.min(this.$refs.control.scrollHeight, this.maxHeight)}px`;
        this.$refs.control.style.overflowY = this.$refs.control.scrollHeight > this.maxHeight ? 'auto' : 'hidden';
      },
      handleKeydown(event) {
        if (!this.submitOnEnter || event.key !== 'Enter' || event.shiftKey || event.isComposing) return;
        event.preventDefault();
        this.$root.requestSubmit();
      },
    };
  },

  chatConversation({ autoScroll = true } = {}) {
    return {
      autoScroll: Boolean(autoScroll),
      init() {
        if (this.autoScroll) this.$nextTick(() => this.scrollToBottom());
      },
      scrollToBottom({ smooth = false } = {}) {
        if (!this.$refs.messages) return;
        this.$refs.messages.scrollTo({
          top: this.$refs.messages.scrollHeight,
          behavior: smooth ? 'smooth' : 'auto',
        });
      },
    };
  },

  overlay(config = {}) {
    return {
      serverOpen: config.serverOpen,
      visible: false,
      active: false,
      closing: false,
      closeTimer: null,
      opener: null,
      scrollLocked: false,
      layer: 200,
      init() {
        if (this.serverOpen) this.openOverlay();
        this.$watch('serverOpen', (value) => value ? this.openOverlay() : this.close(false));
      },
      openOverlay() {
        clearTimeout(this.closeTimer);
        this.closing = false;
        this.opener = document.activeElement;
        this.visible = true;
        this.active = true;
        const openOverlays = document.querySelectorAll('[data-sampaui-overlay-active="true"]').length;
        this.layer = 200 + (openOverlays * 20);
        if (!this.scrollLocked) {
          lockPageScroll();
          this.scrollLocked = true;
        }

        if (this.$refs.dialog && !this.$refs.dialog.open) this.$refs.dialog.showModal();

        const focusElement = () => {
          const focusables = focusableElements(this.$refs.panel);
          (focusables[0] || this.$refs.panel)?.focus();
        };

        if (typeof this.$nextTick === 'function') {
          this.$nextTick(focusElement);
        } else {
          setTimeout(focusElement, 40);
        }
      },
      close(sync = true) {
        if (sync) this.serverOpen = false;
        if (!this.visible || this.closing) return;
        this.closing = true;
        this.active = false;
        clearTimeout(this.closeTimer);
        this.closeTimer = setTimeout(() => {
          this.visible = false;
          if (this.scrollLocked) {
            unlockPageScroll();
            this.scrollLocked = false;
          }
          if (this.$refs.dialog?.open) this.$refs.dialog.close();
          this.closing = false;
          if (config.afterClose) this.$wire?.[config.afterClose]?.();
          this.opener?.focus?.();
        }, Number(config.closeDelay ?? 260));
      },
      handleEscape() {
        if (!config.closeOnEscape) return;
        this.close();
      },
      handleOutside() {
        if (!config.closeOnOutside) return;
        this.close();
      },
      trapTab(event) {
        const items = focusableElements(this.$refs.panel);
        if (!items.length) { event.preventDefault(); this.$refs.panel?.focus(); return; }
        const first = items[0];
        const last = items[items.length - 1];
        if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
        else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
      },
      destroy() {
        clearTimeout(this.closeTimer);
        if (this.scrollLocked) {
          unlockPageScroll();
          this.scrollLocked = false;
        }
      },
    };
  },

  dropdown(config = {}) {
    return {
      ...portalMenu(config),
      open: false,
      init() {
        this.initPortalMenu();
      },
      openMenu() {
        this.open = true;
        this.$nextTick(() => {
          this.positionMenu();
          focusableElements(this.menuElement())[0]?.focus();
        });
      },
      toggle() {
        this.open ? this.close() : this.openMenu();
      },
      close({ focusTrigger = false } = {}) {
        this.open = false;
        if (focusTrigger) this.$nextTick(() => this.triggerElement()?.focus());
      },
      onEscape() {
        if (config.closeOnEscape && this.open) this.close({ focusTrigger: true });
      },
      move(event, step) {
        const items = focusableElements(this.menuElement());
        if (!items.length) return;
        const index = Math.max(items.indexOf(event.target), 0);
        items[(index + step + items.length) % items.length].focus();
      },
      handleMenuOutside(event) {
        if (!config.closeOnOutside || !this.open) return;
        if (this.$root.contains(event.target) || this.menuElement()?.contains(event.target)) return;
        this.close();
      },
      destroy() {
        this.destroyPortalMenu();
      },
    };
  },

  toast({ max = 5, defaultDuration = 3500, variant = 'outline', size = 'md' } = {}) {
    return {
      toasts: [],
      queue: [],
      max: Math.max(Number(max), 1),
      add(payload) {
        const incoming = typeof payload === 'string' ? { message: payload } : (payload ?? {});
        const type = ['success', 'error', 'warning', 'info'].includes(incoming.type) ? incoming.type : 'info';
        const tones = {
          success: ['border-success', 'text-success', 'bg-success', 'check2-circle', 'Sucesso'],
          error: ['border-danger', 'text-danger', 'bg-danger', 'exclamation-octagon', 'Erro'],
          warning: ['border-warning', 'text-warning', 'bg-warning', 'exclamation-triangle', 'Atencao'],
          info: ['border-info', 'text-info', 'bg-info', 'info-circle', 'Aviso'],
        };
        const duration = Number(incoming.duration ?? defaultDuration);
        const safeDuration = Number.isFinite(duration) && duration >= 0 ? duration : defaultDuration;
        const tone = tones[type];
        const selectedVariant = ['soft', 'solid', 'outline'].includes(incoming.variant) ? incoming.variant : variant;
        const variantClasses = {
          soft: `border ${tone[0]} ${tone[2]}/10 text-secondary`,
          solid: `border ${tone[0]} ${tone[2]} text-white`,
          outline: `border ${tone[0]} bg-white text-secondary`,
        };
        const sizeClasses = { sm: 'px-3 py-3', md: 'px-4 py-4', lg: 'px-5 py-5' };
        const toast = { id: `${Date.now()}-${Math.random()}`, show: true, type, title: incoming.title ?? tone[4], message: incoming.message ?? '', duration: safeDuration, remaining: safeDuration, progress: 100, startedAt: null, timerId: null, intervalId: null, pausedBy: [], wrap: `${variantClasses[selectedVariant] ?? variantClasses.outline} ${incoming.class ?? ''}`, contentClass: sizeClasses[incoming.size] ?? sizeClasses[size] ?? sizeClasses.md, icon: selectedVariant === 'solid' ? 'text-white' : tone[1], progressClass: selectedVariant === 'solid' ? 'bg-white' : tone[2], symbol: tone[3] };
        if (this.toasts.length >= this.max) this.queue.push(toast);
        else this.mount(toast);
      },
      mount(toast) {
        this.toasts.unshift(toast);
        this.$nextTick(() => this.startTimer(this.toasts[0]));
      },
      startTimer(toast) {
        if (toast.duration === 0 || toast.remaining <= 0) return;
        toast.startedAt = Date.now();
        toast.intervalId = window.setInterval(() => { toast.progress = Math.max((toast.remaining - (Date.now() - toast.startedAt)) / toast.duration * 100, 0); }, 80);
        toast.timerId = window.setTimeout(() => this.remove(toast.id), toast.remaining);
      },
      pauseTimer(toast, reason = 'manual') {
        if (!toast.pausedBy.includes(reason)) toast.pausedBy.push(reason);
        if (toast.pausedBy.length > 1) return;
        if (toast.startedAt) toast.remaining = Math.max(toast.remaining - (Date.now() - toast.startedAt), 0);
        this.clearTimers(toast);
      },
      resumeTimer(toast, reason = 'manual') {
        toast.pausedBy = toast.pausedBy.filter((item) => item !== reason);
        if (toast.pausedBy.length === 0 && toast.show && toast.remaining > 0) this.startTimer(toast);
      },
      clearTimers(toast) {
        if (!toast) return;
        window.clearTimeout(toast.timerId);
        window.clearInterval(toast.intervalId);
        toast.timerId = null;
        toast.intervalId = null;
        toast.startedAt = null;
      },
      remove(id) {
        const toast = this.toasts.find((item) => item.id === id);
        if (!toast) return;
        this.clearTimers(toast);
        toast.show = false;
        window.setTimeout(() => {
          this.toasts = this.toasts.filter((item) => item.id !== id);
          const next = this.queue.shift();
          if (next) this.mount(next);
        }, 180);
      },
    };
  },

  tooltip(config = {}) {
    return {
      ...portalMenu({
        align: 'center',
        matchTriggerWidth: false,
        isTooltip: true,
        gap: 6,
        ...config,
      }),
      showTooltip: false,
      init() {
        this.initPortalMenu();
      },
      show() {
        this.showTooltip = true;
        this.$nextTick(() => {
          this.positionMenu();
          requestAnimationFrame(() => this.positionMenu());
        });
      },
      hide() {
        this.showTooltip = false;
      },
      toggle() {
        this.showTooltip ? this.hide() : this.show();
      },
      destroy() {
        this.destroyPortalMenu();
      },
    };
  },

  openModal(idOrModel) {
    if (typeof window !== 'undefined') {
      window.dispatchEvent(new CustomEvent('open-modal', { detail: idOrModel }));
    }
  },

  closeModal(idOrModel) {
    if (typeof window !== 'undefined') {
      window.dispatchEvent(new CustomEvent('close-modal', { detail: idOrModel }));
    }
  },

  openDrawer(idOrModel) {
    if (typeof window !== 'undefined') {
      window.dispatchEvent(new CustomEvent('open-drawer', { detail: idOrModel }));
    }
  },

  closeDrawer(idOrModel) {
    if (typeof window !== 'undefined') {
      window.dispatchEvent(new CustomEvent('close-drawer', { detail: idOrModel }));
    }
  },
};

if (typeof window !== 'undefined') {
  window.SampaUI = { ...(window.SampaUI ?? {}), ...SampaUI };
}

if (typeof module !== 'undefined' && module.exports) {
  module.exports = SampaUI;
}
})();

