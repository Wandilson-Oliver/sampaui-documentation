/**
 * SampaUI Playground Livewire Bridge Plugin
 * Emulador reativo do ecossistema Livewire 3 para o preview do Playground.
 */
(function () {
  function sampaUiBridgePlugin(Alpine) {
    // 1. Estado Reativo Global do Livewire
    const rawState = window.rawWireState || {};
    const state = Alpine.reactive({ ...rawState });
    window.wireState = state;

    // 2. Helpers para Overlays (Modal & Drawer)
    function openOverlayTarget(targetKey) {
      if (!targetKey) {
        window.dispatchEvent(new CustomEvent('open-modal'));
        window.dispatchEvent(new CustomEvent('open-drawer'));
        return;
      }
      const candidates = [targetKey, 'sampaui-modal-standalone-' + targetKey, 'sampaui-drawer-standalone-' + targetKey];
      candidates.forEach((name) => {
        window.dispatchEvent(new CustomEvent('open-modal', { detail: name }));
        window.dispatchEvent(new CustomEvent('open-drawer', { detail: name }));
        window.dispatchEvent(new CustomEvent('open-modal-' + name));
        window.dispatchEvent(new CustomEvent('open-drawer-' + name));
      });

      // Acionamento direto de segurança nos escopos Alpine
      document.querySelectorAll('[data-sampaui-overlay]').forEach((el) => {
        if (el._x_dataStack) {
          el._x_dataStack.forEach((scope) => {
            if (scope && typeof scope.openOverlay === 'function' && !scope.visible) {
              const elId = el.getAttribute('id') || '';
              if (!targetKey || candidates.includes(elId) || elId.endsWith('-' + targetKey) || elId.includes(targetKey)) {
                scope.openOverlay();
              }
            }
          });
        }
      });
    }

    function closeOverlayTarget(targetKey) {
      if (!targetKey) {
        window.dispatchEvent(new CustomEvent('close-modal'));
        window.dispatchEvent(new CustomEvent('close-drawer'));
        return;
      }
      const candidates = [targetKey, 'sampaui-modal-standalone-' + targetKey, 'sampaui-drawer-standalone-' + targetKey];
      candidates.forEach((name) => {
        window.dispatchEvent(new CustomEvent('close-modal', { detail: name }));
        window.dispatchEvent(new CustomEvent('close-drawer', { detail: name }));
        window.dispatchEvent(new CustomEvent('close-modal-' + name));
        window.dispatchEvent(new CustomEvent('close-drawer-' + name));
      });

      document.querySelectorAll('[data-sampaui-overlay]').forEach((el) => {
        if (el._x_dataStack) {
          el._x_dataStack.forEach((scope) => {
            if (scope && typeof scope.close === 'function' && scope.visible) {
              const elId = el.getAttribute('id') || '';
              if (!targetKey || candidates.includes(elId) || elId.endsWith('-' + targetKey) || elId.includes(targetKey)) {
                scope.close();
              }
            }
          });
        }
      });
    }

    // 3. Objeto $wire com reatividade bidirecional (two-way binding)
    const wireProxy = new Proxy(state, {
      get(target, prop) {
        if (prop === 'entangle') {
          return (propName, isLive = true) => {
            if (!(propName in target)) {
              target[propName] = false;
            }
            return {
              get live() {
                return Boolean(target[propName]);
              },
              set live(val) {
                target[propName] = Boolean(val);
                if (val) openOverlayTarget(propName);
                else closeOverlayTarget(propName);
              },
              get value() {
                return target[propName];
              },
              set value(val) {
                target[propName] = val;
                if (typeof val === 'boolean') {
                  if (val) openOverlayTarget(propName);
                  else closeOverlayTarget(propName);
                }
              }
            };
          };
        }

        if (prop === '$set' || prop === 'set') {
          return (key, val) => {
            target[key] = val;
            if (val === true || val === 'true' || val === 1) {
              openOverlayTarget(key);
            } else if (val === false || val === 'false' || val === 0) {
              closeOverlayTarget(key);
            }
          };
        }

        if (prop === '$toggle' || prop === 'toggle') {
          return (key) => {
            target[key] = !target[key];
            if (target[key]) openOverlayTarget(key);
            else closeOverlayTarget(key);
          };
        }

        if (prop === '$get' || prop === 'get') {
          return (key) => target[key];
        }

        if (prop === '$dispatch' || prop === 'dispatch') {
          return (eventName, payload) => {
            window.dispatchEvent(new CustomEvent(eventName, { detail: payload }));
            if (eventName === 'open-modal' || eventName === 'open-drawer') {
              openOverlayTarget(typeof payload === 'string' ? payload : (payload?.id || payload?.name || payload?.model || ''));
            } else if (eventName === 'close-modal' || eventName === 'close-drawer') {
              closeOverlayTarget(typeof payload === 'string' ? payload : (payload?.id || payload?.name || payload?.model || ''));
            }
          };
        }

        if (prop === '$refresh' || prop === 'refresh') {
          return () => {};
        }

        if (prop in target) {
          return target[prop];
        }

        // Chamadas de métodos dinâmicos Livewire (ex: save, submit, confirm)
        return (...args) => {
          if (prop === 'save' || prop === 'submit' || prop === 'confirm') {
            const toastData = {
              type: 'success',
              title: 'Salvo com sucesso!',
              message: 'As alterações foram processadas no componente.'
            };
            window.dispatchEvent(new CustomEvent('toast', { detail: toastData }));
            closeOverlayTarget();
          }
        };
      },
      set(target, prop, val) {
        target[prop] = val;
        if (val === true || val === 'true' || val === 1) {
          openOverlayTarget(prop);
        } else if (val === false || val === 'false' || val === 0) {
          closeOverlayTarget(prop);
        }
        return true;
      }
    });

    window.$wire = wireProxy;

    // 4. Registrar Alpine Magic Property $wire
    Alpine.magic('wire', () => wireProxy);

    // 5. Interceptador de eventos wire:click nativo via evento capture
    document.addEventListener('click', (e) => {
      let wireEl = e.target;
      let action = null;
      while (wireEl && wireEl !== document && wireEl !== window) {
        if (wireEl.hasAttribute && wireEl.hasAttribute('wire:click')) {
          action = (wireEl.getAttribute('wire:click') || '').trim();
          break;
        }
        wireEl = wireEl.parentElement;
      }

      if (action) {
        // Atribuição: wire:click="showModal = true"
        if (action.includes('=')) {
          const parts = action.replace(/^\$wire\./, '').split('=');
          const prop = parts[0].trim();
          const val = parts[1].trim().toLowerCase() === 'true' || parts[1].trim() === '1';
          wireProxy.$set(prop, val);
          return;
        }

        // $set / set: wire:click="$set('showCustomerModal', true)"
        if (action.includes('$set(') || action.includes('.set(') || action.startsWith('set(')) {
          const match = action.match(/(?:\$set|set)\(\s*['"]([^'"]+)['"]\s*,\s*(true|false|1|0|'[^']*'|"[^"]*")\s*\)/i);
          if (match) {
            const prop = match[1];
            const val = match[2].toLowerCase() === 'true' || match[2] === '1';
            wireProxy.$set(prop, val);
            return;
          }
        }

        // $toggle / toggle: wire:click="$toggle('showCustomerModal')"
        if (action.includes('$toggle(') || action.includes('.toggle(') || action.startsWith('toggle(')) {
          const match = action.match(/(?:\$toggle|toggle)\(\s*['"]([^'"]+)['"]\s*\)/i);
          if (match) {
            const prop = match[1];
            wireProxy.$toggle(prop);
            return;
          }
        }

        // $dispatch / dispatch: wire:click="$dispatch('open-modal', 'modal-id')"
        if (action.includes('$dispatch(') || action.includes('dispatch(')) {
          const match = action.match(/(?:\$)?dispatch\(\s*['"]([^'"]+)['"](?:\s*,\s*['"]?([^'")]+)['"]?)?\s*\)/i);
          if (match) {
            const ev = match[1];
            const detail = match[2] || '';
            wireProxy.$dispatch(ev, detail);
            return;
          }
        }

        // Propriedade booleana direta ou método no $wire
        if (typeof wireProxy[action] === 'function') {
          wireProxy[action]();
          return;
        }

        if (action in state || typeof state[action] === 'boolean') {
          wireProxy.$toggle(action);
          return;
        }

        // Se for ação com modal ou drawer genérico
        if (action.toLowerCase().includes('modal') || action.toLowerCase().includes('drawer')) {
          const isClose = action.toLowerCase().includes('close') || action.toLowerCase().includes('cancel');
          if (isClose) closeOverlayTarget();
          else openOverlayTarget();
          return;
        }
      }

      // Botões de Cancelar / Fechar
      let btn = e.target;
      while (btn && btn !== document && btn !== window) {
        const tag = (btn.tagName || '').toLowerCase();
        if (tag === 'button' || tag === 'a' || btn.getAttribute('role') === 'button') {
          break;
        }
        btn = btn.parentElement;
      }

      if (btn && btn !== document && btn !== window) {
        const text = (btn.textContent || '').trim().toLowerCase();
        if (text === 'cancelar' || text === 'fechar' || text === 'cancel' || text === 'close') {
          const parentOverlay = btn.closest('[data-sampaui-overlay]');
          const overlayId = parentOverlay ? parentOverlay.id : null;
          closeOverlayTarget(overlayId);
        }
      }
    }, true);

    // 6. Formulários submit com loading dinâmico
    document.addEventListener('submit', (e) => {
      e.preventDefault();
      const form = e.target;
      const submitBtn = form.querySelector('button[type="submit"]') || form.querySelector('button:not([type="button"])');
      const parentOverlay = form.closest('[data-sampaui-overlay]');
      const overlayId = parentOverlay ? parentOverlay.id : null;

      if (submitBtn) {
        const descendants = Array.from(submitBtn.querySelectorAll('*'));
        const loadingIcon = descendants.find((el) => el.hasAttribute('wire:loading') || el.classList.contains('animate-spin') || el.classList.contains('bi-arrow-repeat'));
        const normalIcon = descendants.find((el) => el.hasAttribute('wire:loading.remove') || el.classList.contains('bi-check2') || el.classList.contains('bi-check') || el.classList.contains('bi-save'));

        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-75', 'cursor-wait');

        if (loadingIcon) loadingIcon.style.setProperty('display', 'inline-block', 'important');
        if (normalIcon) normalIcon.style.setProperty('display', 'none', 'important');

        setTimeout(() => {
          submitBtn.disabled = false;
          submitBtn.classList.remove('opacity-75', 'cursor-wait');

          if (loadingIcon) loadingIcon.style.setProperty('display', 'none', 'important');
          if (normalIcon) normalIcon.style.setProperty('display', 'inline-block', 'important');

          const toastData = {
            type: 'success',
            title: 'Salvo com sucesso!',
            message: 'As alterações foram salvas.'
          };

          window.dispatchEvent(new CustomEvent('toast', { detail: toastData }));
          closeOverlayTarget(overlayId);
        }, 400);
      }
    }, true);
  }

  // Auto-registrar no evento alpine:init
  document.addEventListener('alpine:init', () => {
    if (window.Alpine && !window.Alpine.__sampauiBridgeLoaded) {
      window.Alpine.__sampauiBridgeLoaded = true;
      sampaUiBridgePlugin(window.Alpine);
    }
  });

  window.sampaUiBridgePlugin = sampaUiBridgePlugin;
})();
