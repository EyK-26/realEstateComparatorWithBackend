import React, { ChangeEvent, FunctionComponent } from "react";

type PriceRangeProps = {
    handleChange: (e: ChangeEvent<HTMLInputElement>) => void;
    price: number;
    defaultPrice: number;
};

const PriceRange: FunctionComponent<PriceRangeProps> = ({
    handleChange,
    price,
    defaultPrice,
}) => {
    return (
        <div className="price_range__container">
            <label htmlFor="price_range">{`Price Range ${String(
                price
            )} CZK / ${String(defaultPrice)} CZK`}</label>
            <input
                type="range"
                min={1}
                max={defaultPrice}
                step={1}
                name="price_range"
                className="price_range"
                id="price_range"
                onChange={handleChange}
                value={price}
            />
        </div>
    );
};

export default PriceRange;
