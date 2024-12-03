import React from "react";
import PropTypes from "prop-types";

const Button = ({ type, onClick, className, children, disabled }) => {
  return (
    <button
      type={type}
      onClick={onClick}
      className={className}
      disabled={disabled}
    >
      {children}
    </button>
  );
};

Button.propTypes = {
  type: PropTypes.string,
  onClick: PropTypes.func,
  className: PropTypes.string,
  children: PropTypes.node.isRequired,
  disabled: PropTypes.bool,
};

Button.defaultProps = {
  type: "button",
  onClick: () => {},
  className: "",
  disabled: false,
};

function createButton({
  type = "button",
  onClick = () => {},
  className = "",
  text = "",
  disabled = false,
}) {
  const button = document.createElement("button");
  button.type = type;
  button.className = `btn ${className} ${disabled ? "btn-disabled" : ""}`;
  button.textContent = text;
  button.disabled = disabled;
  button.addEventListener("click", onClick);
  return button;
}

export default Button;
